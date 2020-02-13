<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $stagiaires = $this->getDoctrine()
                        ->getRepository(Stagiaire::class)
                        ->getAll() ;

        return $this->render('stagiaire/home.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    /**
     * @Route("/{id}", name="detail_stagiaire")
     */
    public function detail(Stagiaire $stagiaire): Response {
        return $this->render('stagiaire/detail.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }
}
