<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Entity\VehicleEquipment;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VehicleController extends AbstractController
{
    /**
     * @Route("/", name="vehicle_index", methods={"GET"})
     */
    public function index(VehicleRepository $vehicleRepository): Response
    {
        return $this->render('vehicle/index.html.twig', [
            'vehicles' => $vehicleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vehicle_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->redirectToRoute('vehicle_index');
        }

        return $this->render('vehicle/new.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/vehicle/{id}", name="vehicle_show", methods={"GET"})
     */
    public function show(Vehicle $vehicle, $id): Response
    {
        return $this->render('vehicle/show.html.twig', [
            'vehicle' => $vehicle,
            'equipments' => $this->getVehicleEquipments($id),
        ]);
    }

    /**
     * @Route("/vehicle/{id}/edit", name="vehicle_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vehicle $vehicle, $id): Response
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicle_index');
        }

        return $this->render('vehicle/edit.html.twig', [
            'vehicle' => $vehicle,
            'equipments' => $this->getVehicleEquipments($id),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/vehicle/{id}/delete", name="vehicle_delete", methods={"POST"})
     */
    public function delete(Vehicle $vehicle): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($vehicle);
        $entityManager->flush();

        return $this->redirectToRoute('vehicle_index');
    }

    public function getVehicleEquipments($id)
    {
        $em = $this->getDoctrine()->getManager();
        $vehicleEquipments = 
        $em->getRepository(VehicleEquipment::class)->findBy(['vehicle' => $id]);

        return $vehicleEquipments;
    }
}