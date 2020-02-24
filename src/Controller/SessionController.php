<?php
//
// Contrôleur associé à l'entité "Session".
//
// Gère les routes associées aux sessions, et permettant :
//    - d'afficher la liste des sessions (home_session) ;
//    - d'ajouter une nouvelle session (add_session) ;
//    - de modifier une session identifiée (update_session) ;
//    - de supprimer une session identifiée (delete_session) => non utilisée actuellement ;
//    - d'annuler l'inscription d'un stagiaire identifié à une session identifiée (cancel_session) ;
//    - de supprimer un module identifié d'une session identifée (unset_programme) ;
//    - d'afficher les détails d'une session identifiée (detail_session).
//

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\Session;
use App\Entity\Programme;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="home_session")
     */
    public function index()
    {
        $sessions = $this->getDoctrine()
                        ->getRepository(Session::class)
                        ->getAll() ;

        return $this->render('session/home.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * @Route("/add", name="add_session")
     */
    public function add(Request $request, EntityManagerInterface $emi) 
    {
        $session = new Session();
        $session->setDateDebut(new DateTime());
        $session->getDateDebut()->add(new DateInterval("P1D"));
        $session->setDateFin(new DateTime());
        $session->getDateFin()->add(new DateInterval("P14D"));

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $emi->persist($session);
            $emi->flush();

            return $this->redirectToRoute('home_session');
        }
        
        return $this->render('session/form.html.twig', [
            "form" => $form->createView(),
            "title" => "Ajouter",
            "sessionId" => $session->getId()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update_session")
     */
    public function update(Session $session, Request $request, EntityManagerInterface $emi)
    {
        if ($session->getFuture()) {
            $form = $this->createForm(SessionType::class, $session);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $emi->persist($session);
                $emi->flush();

                return $this->redirectToRoute('detail_session', ["id" => $session->getId()]);
            }
            
            return $this->render('session/form.html.twig', [
                "form" => $form->createView(),
                "title" => "Modifier",
                "sessionId" => $session->getId()
            ]);
        } else {
            return $this->redirectToRoute('home_session');
        }
    }

    /**
     * @Route("/delete/{id}", name="delete_session")
     */
    public function delete(Session $session, EntityManagerInterface $emi)
    {
        if ($session->getFuture()) {
                $emi->remove($session);
            $emi->flush();

            return $this->redirectToRoute("home");
        } else {
            return $this->redirectToRoute('home_session');
        }
    }

     /**
     * @Route("/cancel/{id}/{stagiaireId}", name="cancel_session")
     */
    public function cancel(Session $session, Request $request, EntityManagerInterface $emi)
    {
        $stagiaireId = $request->attributes->get('stagiaireId') ;

        if ($stagiaireId != null) {
            $stagiaire = $this->getDoctrine()
                            ->getRepository(Stagiaire::class)
                            ->find($stagiaireId) ;

            $session->removeStagiaire($stagiaire) ;
            $emi->flush();
        }

        return $this->redirectToRoute("detail_session", [
            'id' => $session->getId() 
        ]);
    }

     /**
     * @Route("/unset/{id}/{programmeId}", name="unset_programme")
     */
    public function unset(Session $session, Request $request, EntityManagerInterface $emi)
    {
        $programmeId = $request->attributes->get('programmeId') ;

        if ($programmeId != null) {
            $programme = $this->getDoctrine()
                            ->getRepository(Programme::class)
                            ->find($programmeId) ;

            $session->removeProgramme($programme) ;
            $emi->flush();
        }

        return $this->redirectToRoute("detail_session", [
            'id' => $session->getId() 
        ]);
    }

    /**
     * @Route("/{id}", name="detail_session")
     */
    public function detail(Session $session): Response {
        return $this->render('session/detail.html.twig', [
            'session' => $session,
        ]);
    }
}
