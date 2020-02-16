<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/add", name="add_stagiaire")
     */
    public function add(Request $request, EntityManagerInterface $emi) 
    {
        $stagiaire = new Stagiaire();

        $form = $this->createForm(StagiaireType::class, $stagiaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $emi->persist($stagiaire);
            $emi->flush();

            return $this->redirectToRoute('home_stagiaire');
        }
        
        return $this->render('stagiaire/form.html.twig', [
            "form" => $form->createView()
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
