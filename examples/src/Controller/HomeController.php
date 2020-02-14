<?php

namespace App\Controller;

use App\Repository\VehicleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function accueil(VehicleRepository $vrepo)
    {

        
        return $this->render('home/index.html.twig', [
            "vehicles" => $vrepo->findAll()
        ]);
    }

  
}
