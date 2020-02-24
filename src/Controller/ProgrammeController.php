<?php
//
// Contrôleur non utilisé en réalité, associé à l'entité "Programme". 
//
// L'entité "Programme" est créée uniquement pour gérer la relation "ManyToMany" entre les entités "Session" et "Module", 
// relation nécessitant un attribut de caractérisation complémentaire "durée".
//

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
