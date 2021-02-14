<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="model")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModelRepository")
 */
class Model implements \JsonSerializable
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name = null;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand", inversedBy="models")
     * @ORM\JoinColumn(name="brand", referencedColumnName="id")
     */
    private $brand;

    public function __construct(string $name = null)
    {
        $this->name = $name;
    }

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
    public function setName(string $name): Model
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

    /**
     * Set brand
     */
    public function setBrand(Brand $brand): Model
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' =>  $this->name,
        ];
    }
}
