<?php

namespace App\Controller;

use App\Entity\VehicleEquipment;
use App\Form\VehicleEquipmentType;
use App\Repository\VehicleEquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vehicle/equipment")
 */
class VehicleEquipmentController extends AbstractController
{
    /**
     * @Route("/", name="vehicle_equipment_index", methods={"GET"})
     */
    public function index(VehicleEquipmentRepository $vehicleEquipmentRepository): Response
    {
        return $this->render('vehicle_equipment/index.html.twig', [
            'vehicle_equipments' => $vehicleEquipmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vehicle_equipment_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $vehicleEquipment = new VehicleEquipment();
        $form = $this->createForm(VehicleEquipmentType::class, $vehicleEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicleEquipment);
            $entityManager->flush();

            return $this->redirectToRoute('vehicle_equipment_index');
        }

        return $this->render('vehicle_equipment/new.html.twig', [
            'vehicle_equipment' => $vehicleEquipment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{vehicle}", name="vehicle_equipment_show", methods={"GET"})
     */
    public function show(VehicleEquipment $vehicleEquipment): Response
    {
        return $this->render('vehicle_equipment/show.html.twig', [
            'vehicle_equipment' => $vehicleEquipment,
        ]);
    }

    /**
     * @Route("/{vehicle}/edit", name="vehicle_equipment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VehicleEquipment $vehicleEquipment): Response
    {
        $form = $this->createForm(VehicleEquipmentType::class, $vehicleEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicle_equipment_index');
        }

        return $this->render('vehicle_equipment/edit.html.twig', [
            'vehicle_equipment' => $vehicleEquipment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{vehicle}/{equipment}/delete", name="vehicle_equipment_delete", methods={"POST"})
     */
    public function delete($vehicle, $equipment): Response
    {
        $em = $this->getDoctrine()->getManager();
        $equipmentToDelete = 
        $em->getRepository(VehicleEquipment::class)->findOneBy([
            'vehicle' => $vehicle,
            'equipment' => $equipment
            ]);
        $em->remove($equipmentToDelete);
        $em->flush();

        return $this->redirectToRoute('vehicle_equipment_index');
    }
}