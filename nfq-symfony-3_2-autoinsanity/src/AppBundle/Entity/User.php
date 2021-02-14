<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Vehicle", inversedBy="users", fetch="LAZY", cascade="persist")
     * @ORM\JoinTable(name="users_vehicles")
     */
    private $pinnedVehicles;

    /**
     * @ORM\OneToMany(targetEntity="VehicleSearch", mappedBy="user", fetch="LAZY", cascade="persist")
     */
    private $searches;

    public function __construct()
    {
        parent::__construct();
        $this->pinnedVehicles = new ArrayCollection();
        $this->searches = new ArrayCollection();
    }

    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        // we use email only login/register
        $this->setUsername($email);

        return $this;
    }

    /**
     * Add pinnedVehicle
     */
    public function addPinnedVehicle(Vehicle $pinnedVehicle): User
    {
        $this->pinnedVehicles[] = $pinnedVehicle;

        return $this;
    }

    /**
     * Remove pinnedVehicle
     */
    public function removePinnedVehicle(Vehicle $pinnedVehicle)
    {
        $this->pinnedVehicles->removeElement($pinnedVehicle);
    }

    /**
     * Get pinnedVehicles
     */
    public function getPinnedVehicles(): Collection
    {
        return $this->pinnedVehicles;
    }

    /**
     * Add search
     */
    public function addSearch(VehicleSearch $search): User
    {
        $this->searches[] = $search;

        return $this;
    }

    /**
     * Remove search
     */
    public function removeSearch(VehicleSearch $search)
    {
        $this->searches->removeElement($search);
        $search->setUser(null);
    }

    /**
     * Get searches
     */
    public function getSearches(): Collection
    {
        return $this->searches;
    }
}
