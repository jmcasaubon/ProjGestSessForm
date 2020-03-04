<?php
//
// Contrôleur associé à l'entité "Stagiaire".
//
// Gère les routes associées aux stagiaires, et permettant :
//    - d'afficher la liste des stagiaires (home_stagiaire) ;
//    - d'ajouter un nouveau stagiaire (add_stagiaire) ;
//    - de modifier un stagiaire identifié (update_stagiaire) ;
//    - de supprimer un stagiaire identifié (delete_stagiaire) => non utilisée actuellement ;
//    - d'inscrire un stagiaire identifié à une session identifiée (register_stagiaire) ;
//    - d'annuler l'inscription d'un stagiaire identifié à une session identifiée (cancel_stagiaire) ;
//    - d'afficher les détails d'un stagiaire identifié (detail_stagiaire).
//

namespace App\Controller;

use DateTime;
use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/stagiaire")
 */
class StagiaireController extends AbstractController
{
    /**
     * @Route("/", name="home_stagiaire")
     */
    public function index()
    {
        $stagiaires = $this->getDoctrine()
                        ->getRepository(Stagiaire::class)
                        ->getAll() ;

        return $this->render('stagiaire/home.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    /**
     * @Route("/add", name="add_stagiaire")
     */
    public function add(Request $request, EntityManagerInterface $emi) 
    {
        $stagiaire = new Stagiaire();

        $form = $this->createForm(StagiaireType::class, $stagiaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if (($stagiaire->getCpostal() == "") || ($stagiaire->getVille() > "")) {
                try {
                    $emi->persist($stagiaire);
                    $emi->flush();

                    return $this->redirectToRoute('home_stagiaire');
                }
                catch (UniqueConstraintViolationException $e) {
                    $this->addFlash('danger', "Cette adresse de messagerie est déjà utilisée !");
                }
            } else {
                if ($stagiaire->getCpostal() > "") {
                    $this->addFlash('danger', "Le code postal saisi n'est associé à aucune commune !");
                }
            }
        }
        
        return $this->render('stagiaire/form.html.twig', [
            "form" => $form->createView(),
            "title" => "Ajouter"
        ]);
    }

    /**
     * @Route("/update/{id}", name="update_stagiaire")
     */
    public function update(Stagiaire $stagiaire, Request $request, EntityManagerInterface $emi)
    {
        $form = $this->createForm(StagiaireType::class, $stagiaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if (($stagiaire->getCpostal() == "") || ($stagiaire->getVille() > "")) {
                try {
                    $emi->flush();

                    return $this->redirectToRoute('detail_stagiaire', ["id" => $stagiaire->getId()]);
                }
                catch (UniqueConstraintViolationException $e) {
                    $this->addFlash('danger', "Cette adresse de messagerie est déjà utilisée !");
                }
            } else {
                if ($stagiaire->getCpostal() > "") {
                    $this->addFlash('danger', "Le code postal saisi n'est associé à aucune commune !");
                }
            }
        }
                
        return $this->render('stagiaire/form.html.twig', [
            "form" => $form->createView(),
            "title" => "Modifier"
        ]);
    }

    /**
     * @Route("/confirm", name="confirm_delete_anonymize_stagiaire")
     */
    public function confirm(Request $request, EntityManagerInterface $emi)
    {
        $stagiaireId = $request->query->get("id") ;
        $stagiaire = $emi->getRepository(Stagiaire::class)->findOneBy(['id' => $stagiaireId]) ;

        $html = $this->renderView('stagiaire/ajax.html.twig', [
            "stagiaire" => $stagiaire
        ]) ;

        return new Response($html) ;
    }

    /**
     * @Route("/delete/{id}", name="delete_stagiaire")
     */
    public function delete(Stagiaire $stagiaire, EntityManagerInterface $emi)
    {
        if ($stagiaire->getNbSessionsSuivies() == 0) {
            $emi->remove($stagiaire);
            $emi->flush();
        } else {
            $this->addFlash('danger', "Seul un stagiaire inscrit à aucune session peut être supprimé !");
        }

        return $this->redirectToRoute("home_stagiaire");
    }

    /**
     * @Route("/anon/{id}", name="anonymize_stagiaire")
     */
    public function anonymize(Stagiaire $stagiaire, EntityManagerInterface $emi)
    {
        $anonymous = $this->getDoctrine()
                        ->getRepository(Stagiaire::class)
                        ->getAnonymous() ;
        $anonId = sprintf("_anonymous_%04d", count($anonymous));

        $stagiaire->setNom($anonId);
        $stagiaire->setPrenom("");
        $stagiaire->setDateNaissance(new DateTime());
        $stagiaire->setSexe("-");
        $stagiaire->setAdresse("");
        $stagiaire->setCpostal("");
        $stagiaire->setVille("");
        $stagiaire->setTelephone("");
        $stagiaire->setMail($anonId."@nobody.fr");

        $emi->flush();

        return $this->redirectToRoute("home_stagiaire");
    }

    /**
     * @Route("/register/{id}", name="register_stagiaire")
     */
    public function register(Stagiaire $stagiaire, Request $request, EntityManagerInterface $emi)
    {
        $sessionId = $request->request->get('sessionId') ;

        if ($sessionId != null) {
            $session = $this->getDoctrine()
                        ->getRepository(Session::class)
                        ->find($sessionId) ;
            
            $ok = true ;
            foreach ($stagiaire->getSessions() as $sessionSuivie) {
                if ((($session->getDateDebut() >= $sessionSuivie->getDateDebut()) && 
                    ($session->getDateDebut() <= $sessionSuivie->getDateFin()))
                    ||
                    (($session->getDateFin() >= $sessionSuivie->getDateDebut()) && 
                    ($session->getDateFin() <= $sessionSuivie->getDateFin()))) {
                        $ok = false ;
                    }
            }

            if ($ok) {
                $stagiaire->addSession($session) ;
                $emi->flush();
            } else {
                $this->addFlash('danger', "Le stagiaire ne peut pas être inscrit à cette session (chevauchement avec une autre session à laquelle il est déjà inscrit) !");
            }
        }

        return $this->redirectToRoute("detail_stagiaire", [
            'id' => $stagiaire->getId() 
        ]);
    }

    /**
     * @Route("/cancel/{id}/{sessionId}", name="cancel_stagiaire")
     */
    public function cancel(Stagiaire $stagiaire, Request $request, EntityManagerInterface $emi)
    {
        $sessionId = $request->attributes->get('sessionId') ;

        if ($sessionId != null) {
            $session = $this->getDoctrine()
                            ->getRepository(Session::class)
                            ->find($sessionId) ;

            $stagiaire->removeSession($session) ;
            $emi->flush();
        }

        return $this->redirectToRoute("detail_stagiaire", [
            'id' => $stagiaire->getId() 
        ]);
    }

    /**
     * @Route("/{id}", name="detail_stagiaire")
     */
    public function detail(Stagiaire $stagiaire): Response {
        // $sessions = $this->getDoctrine()
        //             ->getRepository(Session::class)
        //             ->getAllFuture() ;
                    
        $sessions = $this->getDoctrine()
            ->getRepository(Stagiaire::class)
            ->getSessionsNonParticipant($stagiaire->getId());
        
        return $this->render('stagiaire/detail.html.twig', [
            'stagiaire' => $stagiaire,
            'sessions' => $sessions
        ]);
    }
}
