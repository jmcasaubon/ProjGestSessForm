<?php
// 
// Contrôleur indépendant (non lié à une entité), uniquement chargé de la route vers la page d'accueil.
//

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Categorie;
use App\Entity\Stagiaire;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $sessions = $this->getDoctrine()
                        ->getRepository(Session::class)
                        ->getAll() ;

        $stagiaires = $this->getDoctrine()
                        ->getRepository(Stagiaire::class)
                        ->getAll() ;

        $categories = $this->getDoctrine()
                        ->getRepository(Categorie::class)
                        ->findAll() ;

        $modules = $this->getDoctrine()
                        ->getRepository(Module::class)
                        ->findAll() ;

        return $this->render('home/index.html.twig', [
            'stagiaires' => $stagiaires,
            'sessions' => $sessions,
            'categories' => $categories,
            'modules' => $modules
        ]);
    }
}
