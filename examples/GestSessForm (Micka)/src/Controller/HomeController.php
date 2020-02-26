<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Entity\Session;
use App\Entity\Module;
use App\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $nbStagiaires = \sizeof($this->getDoctrine()
            ->getRepository(Stagiaire::class)
            ->getAll());

        $nbSessions = \sizeof($this->getDoctrine()
            ->getRepository(Session::class)
            ->getAll());

        $nbModules = \sizeof($this->getDoctrine()
            ->getRepository(Module::class)
            ->getAll());

        $nbMatieres = \sizeof($this->getDoctrine()
            ->getRepository(Matiere::class)
            ->getAll());

        return $this->render('home/index.html.twig',[
            'nbStagiaires' => $nbStagiaires,
            'nbSessions' => $nbSessions,
            'nbModules' => $nbModules,
            'nbMatieres' => $nbMatieres
        ]);
    }
}
