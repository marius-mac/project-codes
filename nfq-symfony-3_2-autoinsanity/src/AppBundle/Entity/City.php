<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Country;
use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CityRepository")
 */
class City implements \JsonSerializable
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
     * @var Country
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country", inversedBy="cities")
     * @ORM\JoinColumn(name="country", referencedColumnName="id")
     */
    private $country;

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
    public function setName(string $name): City
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
     * Set country
     */
    public function setCountry(Country $country = null): City
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     */
    public function getCountry(): Country
    {
        return $this->country;
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
