<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Entity\Session;
use App\Form\StagiaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/stagiaire")
 */
class StagiaireController extends AbstractController
{
    /**
     * @Route("/", name="stagiaire")
     */
    public function index(){
        $stagiaires = $this->getDoctrine()
                        ->getRepository(Stagiaire::class)
                        ->getAll();

        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    /**
     * @Route("/add", name="add_stagiaire")
     * @Route("/{id}/edit", name="edit_stagiaire")
     */
    public function addStagiaire(Stagiaire $stagiaire = null, Request $request){

        if(!$stagiaire){
            $stagiaire = new Stagiaire();
        }
        // $stagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $stagiaire = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stagiaire);
            $entityManager->flush();

            return $this->redirectToRoute('stagiaire');
        }

        return $this->render('stagiaire/add.html.twig', [
            'form' => $form->createView(), 'id' => $stagiaire->getId()
        ]);
    }

    /**
     * @Route("/{id}/remove_session/{id_session}", name="stagiaire_remove_session")
     */
    public function removeSession(Stagiaire $stagiaire, Request $request){

        $manager = $this->getDoctrine()->getManager();
        $id_session = $request->attributes->get('id_session');
        $session = $this->getDoctrine()
                        ->getRepository(Session::class)
                        ->find($id_session);
        $stagiaire->removeSession($session);
        $manager->flush();
        return $this->redirectToRoute('stagiaire_show', array('id' => $stagiaire->getId()));
    }

    /**
     * @Route("/{id}/add_session/{id_session}", name="stagiaire_add_session")
     */
    public function addSession(Stagiaire $stagiaire, Request $request){

        $manager = $this->getDoctrine()->getManager();
        $id_session = $request->attributes->get('id_session');
        $session = $this->getDoctrine()
                        ->getRepository(Session::class)
                        ->find($id_session);
        $stagiaire->addSession($session);
        $manager->flush();
        // $this->addFlash(
        //     'notice',
        //     'La session a bien été ajoutée !'
        // );
        return $this->redirectToRoute('stagiaire_show', array('id' => $stagiaire->getId()));
    }


    /**
     * @Route("/{id}", name="stagiaire_show")
     */
    public function show(Stagiaire $stagiaire){

        $id = $stagiaire->getId();

        $sessionsDispo = $this->getDoctrine()
                            ->getRepository(Stagiaire::class)
                            ->getSessionsDispo($id);

        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire, 'sessionsDispo' => $sessionsDispo
        ]);
    }
}
