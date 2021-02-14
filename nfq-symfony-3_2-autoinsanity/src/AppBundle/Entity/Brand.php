<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Model;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrandRepository")
 */
class Brand
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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Model", mappedBy="brand", cascade="persist")
     */
    private $models;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->models = new ArrayCollection();
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
    public function setName(string $name): Brand
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
     * Add model
     */
    public function addModel(Model $model): Brand
    {
        $this->models[] = $model;

        return $this;
    }

    /**
     * Remove model
     */
    public function removeModel(Model $model)
    {
        $this->models->removeElement($model);
    }

    /**
     * Get models
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
