<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('stagiaire/home.html.twig', [
            'controller_name' => 'StagiaireController',
        ]);
    }
}
