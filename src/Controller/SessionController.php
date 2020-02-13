<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
