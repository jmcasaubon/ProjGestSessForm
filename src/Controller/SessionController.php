<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
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
     * @Route("/{id}", name="detail_session")
     */
    public function detail(Session $session): Response {
        return $this->render('session/detail.html.twig', [
            'session' => $session,
        ]);
    }
}
