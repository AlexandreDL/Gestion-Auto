<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Registration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Brand;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Model;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VehicleEquipment", mappedBy="vehicle")
     */
    private $vehicleEquipments;

    public function __construct()
    {
        $this->vehicleEquipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistration(): ?string
    {
        return $this->Registration;
    }

    public function setRegistration(string $Registration): self
    {
        $this->Registration = $Registration;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): self
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->Model;
    }

    public function setModel(string $Model): self
    {
        $this->Model = $Model;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->Color;
    }

    public function setColor(string $Color): self
    {
        $this->Color = $Color;

        return $this;
    }

    /**
     * @return Collection|VehicleEquipment[]
     */
    public function getVehicleEquipments(): Collection
    {
        return $this->vehicleEquipments;
    }

    public function addVehicleEquipment(VehicleEquipment $vehicleEquipment): self
    {
        if (!$this->vehicleEquipments->contains($vehicleEquipment)) {
            $this->vehicleEquipments[] = $vehicleEquipment;
            $vehicleEquipment->setVehicle($this);
        }

        return $this;
    }

    public function removeVehicleEquipment(VehicleEquipment $vehicleEquipment): self
    {
        if ($this->vehicleEquipments->contains($vehicleEquipment)) {
            $this->vehicleEquipments->removeElement($vehicleEquipment);
            // set the owning side to null (unless already changed)
            if ($vehicleEquipment->getVehicle() === $this) {
                $vehicleEquipment->setVehicle(null);
            }
        }

        return $this;
    }
}
