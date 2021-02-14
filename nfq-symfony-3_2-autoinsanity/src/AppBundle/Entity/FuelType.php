<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FuelType
 *
 * @ORM\Table(name="fuel_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FuelTypeRepository")
 */
class FuelType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true, nullable=true)
     */
    private $name = null;


    /**
     * Get id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name
     */
    public function setName(string $name): FuelType
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
