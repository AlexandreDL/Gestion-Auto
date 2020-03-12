<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleEquipmentRepository")
 */
class VehicleEquipment
{

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicle", inversedBy="vehicleEquipments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment", inversedBy="equipmentVehicle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LongName;

    /**
     * @ORM\Column(type="integer")
     */
    private $poids;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongName(): ?string
    {
        return $this->LongName;
    }

    public function setLongName(string $LongName): self
    {
        $this->LongName = $LongName;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }
}