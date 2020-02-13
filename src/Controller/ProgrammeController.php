<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/programme")
 */
class ProgrammeController extends AbstractController
{
    /**
     * @Route("/", name="home_programme")
     */
    public function index()
    {
        return $this->render('programme/home.html.twig', [
            'controller_name' => 'ProgrammeController',
        ]);
    }
}
