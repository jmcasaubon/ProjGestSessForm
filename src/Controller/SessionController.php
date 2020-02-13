<?php

namespace App\Controller;

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
        return $this->render('session/home.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }
}
