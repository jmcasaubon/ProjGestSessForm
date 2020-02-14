<?php

namespace App\Controller;

use App\Entity\Session;
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
     * @Route("/{id}", name="detail_session")
     */
    public function detail(Session $session): Response {
        return $this->render('session/detail.html.twig', [
            'session' => $session,
        ]);
    }
}
