<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function index()
    {
        return $this->render('vehicle/index.html.twig', [
            'controller_name' => 'VehicleController',
        ]);
    }

     /**
     * @Route("/show/{id}", name="show_one")
     */
    public function show()
    {
        return $this->render('vehicle/show.html.twig', [
            'controller_name' => 'VehicleController',
        ]);
    }
}
