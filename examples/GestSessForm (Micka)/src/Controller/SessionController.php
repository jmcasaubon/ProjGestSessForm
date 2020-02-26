<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="session")
     */
    public function index()
    {
        $sessions = $this->getDoctrine()
                        ->getRepository(Session::class)
                        ->getAll();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * @Route("/add", name="add_session")
     * @Route("/{id}/edit", name="edit_session")
     */
    public function addSession(Session $session = null, Request $request){

        if(!$session){
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('session');
        }

        return $this->render('session/add.html.twig', [
            'form' => $form->createView(), 'id' => $session->getId()
        ]);
    }

    /**
     * @Route("/{id}/remove_stagiaire/{id_stagiaire}", name="session_remove_stagiaire")
     */
    public function removeStagiaire(Session $session, Request $request){

        $manager = $this->getDoctrine()->getManager();
        $id_stagiaire = $request->attributes->get('id_stagiaire');
        $stagiaire = $this->getDoctrine()
                        ->getRepository(Stagiaire::class)
                        ->find($id_stagiaire);
        $session->removeStagiaire($stagiaire);
        $manager->flush();
        return $this->redirectToRoute('session_show', array('id' => $session->getId()));
    }

    /**
     * @Route("/{id}/add_stagiaire/{id_stagiaire}", name="session_add_stagiaire")
     */
    public function addStagiaire(Session $session, Request $request){

        $manager = $this->getDoctrine()->getManager();
        $id_stagiaire = $request->attributes->get('id_stagiaire');
        $stagiaire = $this->getDoctrine()
                        ->getRepository(Stagiaire::class)
                        ->find($id_stagiaire);
        $session->addStagiaire($stagiaire);
        $manager->flush();
        return $this->redirectToRoute('session_show', array('id' => $session->getId()));
    }

    /**
     * @Route("/{id}", name="session_show")
     */
    public function show(Session $session){

        $id = $session->getId();

        $stagiairesNonInscrits = $this->getDoctrine()
                            ->getRepository(Session::class)
                            ->getNonInscrits($id);


        return $this->render('session/show.html.twig', ['session' => $session, 'nonInscrits' => $stagiairesNonInscrits]);
    }
}
