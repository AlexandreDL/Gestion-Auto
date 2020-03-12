<?php

namespace App\Entity;

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
    private $Short_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Long_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $Weight;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortName(): ?string
    {
        return $this->Short_name;
    }

    public function setShortName(string $Short_name): self
    {
        $this->Short_name = $Short_name;

        return $this;
    }

    public function getLongName(): ?string
    {
        return $this->Long_name;
    }

    public function setLongName(string $Long_name): self
    {
        $this->Long_name = $Long_name;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->Weight;
    }

    public function setWeight(int $Weight): self
    {
        $this->Weight = $Weight;

        return $this;
    }
}
