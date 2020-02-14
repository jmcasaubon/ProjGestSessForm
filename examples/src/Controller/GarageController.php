<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/garage")
 */
class GarageController extends AbstractController
{
    /**
     * @Route("/view/{id}", name="view_vehicle")
     */
    public function view(Vehicle $vehicle)
    {
        return $this->render('garage/view.html.twig', [
            'vehicle' => $vehicle
        ]);
    }

    /**
     * @Route("/add", name="add_vehicle")
     * @IsGranted("ROLE_USER")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $vehicle = new Vehicle();

        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($vehicle->getUser() == null){
                $vehicle->setUser($this->getUser());
            }
            
            $em->persist($vehicle);
            $em->flush();

            $this->addFlash("success", "Véhicule bien ajouté, merci !");
            return $this->redirectToRoute('home');
        }
        
        return $this->render('garage/form.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit_vehicle")
     * @IsGranted("ROLE_USER")
     */
    public function edit(Vehicle $vehicle, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->flush();

            $this->addFlash("success", "Véhicule modifié, c'est bon !");
            return $this->redirectToRoute('view_vehicle', ["id" => $vehicle->getId()]);
        }
        
        return $this->render('garage/form.html.twig', [
            "form" => $form->createView()
        ]);
    }

     /**
     * @Route("/delete/{id}", name="delete_vehicle")
     */
    public function delete(Vehicle $vehicle, EntityManagerInterface $em)
    {
        if($this->getUser() === $vehicle->getUser()){
            $em->remove($vehicle);
            $em->flush();
            $this->addFlash("success", "Véhicule supprimé avec succès !");
        }
        else{
            $this->addFlash("error", "Pour qui tu te prends ??!");
        }

        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/user-vehicles", name="user_vehicles")
     */
    public function listByUser(){

        return $this->render('garage/list_user_vehicles.html.twig');
    }
}
