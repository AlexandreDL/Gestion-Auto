<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Entity\Vehicle;
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
     * @Route("/new/{vehicleId}", name="vehicle_equipment_new", methods={"POST"})
     */
    public function new(Request $request, $vehicleId): Response
    {
        $vehicleEquipment = new VehicleEquipment();
        $form = $this->createForm(VehicleEquipmentType::class, $vehicleEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if (($em->getRepository(VehicleEquipment::class)->findOneBy([
                'vehicle' => $vehicleId,
                'equipment' => $vehicleEquipment->getEquipment()->getId()
            ])) !== null) {
                $this->addFlash('alert', 'Ce véhicule possède déjà cet équipement !');
            } else {
                // On affecte le vehicle actuellement modifié à $vehicleEquipment
                $vehicle = $em->getRepository(Vehicle::class)->findOneBy([
                    'id' => $vehicleId
                ]);
                $equipment = $em->getRepository(Equipment::class)->findOneBy([
                    'id' => $vehicleEquipment->getEquipment()->getId()
                ]);

                $vehicleEquipment
                    ->setVehicle($vehicle)
                    ->setEquipment($equipment)
                    ->setLongName($equipment->getLongName())
                    ->setWeight($equipment->getWeight());

                $em->persist($vehicleEquipment);
                $em->flush();

                $this->addFlash('success', 'Cet équipement a bien été ajouté !');
            }
        }
        return $this->render('vehicle_equipment/new.html.twig', [
            'vehicle' => $vehicleId,
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
     * @Route("/{vehicle}/edit/{equipment}", name="vehicle_equipment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VehicleEquipment $vehicleEquipment, $equipment, $vehicle): Response
    {
        $form = $this->createForm(VehicleEquipmentType::class, $vehicleEquipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // On affecte la modification de l'equipment à $vehicleEquipment
            $equipmentToUpdate = $em->getRepository(Equipment::class)->findOneBy([
                'id' => $equipment
            ]);
            $vehicleEquipment->setEquipment($equipmentToUpdate);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Cet équipement a bien été modifié !');
        }

        return $this->render('vehicle_equipment/edit.html.twig', [
            'vehicle' => $vehicle,
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

        return $this->redirectToRoute(
            'vehicle_edit',
            ['id' => $vehicle]
        );
    }
}