<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentRepository")
 */
class Equipment
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
    private $ShortName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LongName;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $Weight;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VehicleEquipment", mappedBy="equipment")
     */
    private $equipmentVehicle;

    public function __construct()
    {
        $this->equipmentVehicle = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortName(): ?string
    {
        return $this->ShortName;
    }

    public function setShortName(string $ShortName): self
    {
        $this->ShortName = $ShortName;

        return $this;
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

    public function getWeight(): ?string
    {
        return $this->Weight;
    }

    public function setWeight(string $Weight): self
    {
        $this->Weight = $Weight;

        return $this;
    }

    /**
     * @return Collection|VehicleEquipment[]
     */
    public function getEquipmentVehicle(): Collection
    {
        return $this->equipmentVehicle;
    }

    public function addEquipmentVehicle(VehicleEquipment $equipmentVehicle): self
    {
        if (!$this->equipmentVehicle->contains($equipmentVehicle)) {
            $this->equipmentVehicle[] = $equipmentVehicle;
            $equipmentVehicle->setEquipment($this);
        }

        return $this;
    }

    public function removeEquipmentVehicle(VehicleEquipment $equipmentVehicle): self
    {
        if ($this->equipmentVehicle->contains($equipmentVehicle)) {
            $this->equipmentVehicle->removeElement($equipmentVehicle);
            // set the owning side to null (unless already changed)
            if ($equipmentVehicle->getEquipment() === $this) {
                $equipmentVehicle->setEquipment(null);
            }
        }

        return $this;
    }
}
