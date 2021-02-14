<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * VehicleSearch
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleSearchRepository")
 * @ORM\Table(name="vehicle_search")
 */
class VehicleSearch
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="searches")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="pinned", type="integer", nullable=true)
     */
    private $pinned = 0;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Provider", fetch="LAZY")
     * @ORM\JoinTable(name="searches_providers")
     */
    private $provider;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand")
     * @ORM\JoinColumn(name="brand", referencedColumnName="id")
     */
    private $brand;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Model", fetch="LAZY")
     * @ORM\JoinTable(name="searches_models")
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="price_from", type="integer", nullable=true)
     */
    private $priceFrom;

    /**
     * @var int
     *
     * @ORM\Column(name="price_to", type="integer", nullable=true)
     */
    private $priceTo;

    /**
     * @var int
     *
     * @ORM\Column(name="year_from", type="integer", nullable=true)
     */
    private $yearFrom;

    /**
     * @var int
     *
     * @ORM\Column(name="year_to", type="integer", nullable=true)
     */
    private $yearTo;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country")
     * @ORM\JoinColumn(name="country", referencedColumnName="id")
     */
    private $country;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="City", fetch="LAZY")
     * @ORM\JoinTable(name="searches_cities")
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="engine_size_to", type="integer", nullable=true)
     */
    private $engineSizeTo = null;

    /**
     * @var int
     *
     * @ORM\Column(name="engine_size_from", type="integer", nullable=true)
     */
    private $engineSizeFrom = null;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="BodyType", fetch="LAZY")
     * @ORM\JoinTable(name="searches_body_types")
     */
    private $bodyType;

    /**
     * @var int
     *
     * @ORM\Column(name="power_from", type="integer", nullable=true)
     */
    private $powerFrom = null;

    /**
     * @var int
     *
     * @ORM\Column(name="power_to", type="integer", nullable=true)
     */
    private $powerTo = null;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="FuelType", fetch="LAZY")
     * @ORM\JoinTable(name="searches_fuel_types")
     */
    private $fuelType;

    /**
     * @var int
     *
     * @ORM\Column(name="doors_number", type="integer", nullable=true)
     */
    private $doorsNumber = null;

    /**
     * @var int
     *
     * @ORM\Column(name="seats_number", type="integer", nullable=true)
     */
    private $seatsNumber = null;

    /**
     * @var int
     *
     * @ORM\Column(name="drive_type", type="integer", nullable=true)
     */
    private $driveType = null;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Transmission", fetch="LAZY")
     * @ORM\JoinTable(name="searches_transmissions")
     */
    private $transmission = null;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="ClimateControl", fetch="LAZY")
     * @ORM\JoinTable(name="searches_climate_controls")
     */
    private $climateControl = null;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Color", fetch="LAZY")
     * @ORM\JoinTable(name="searches_colors")
     */
    private $color;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Defects", fetch="LAZY")
     * @ORM\JoinTable(name="searches_defects")
     */
    private $defects;

    /**
     * @var int
     *
     * @ORM\Column(name="steering_wheel", type="integer", nullable=true)
     */
    private $steeringWheel = null;

    /**
     * @var int
     *
     * @ORM\Column(name="wheels_diameter", type="integer", nullable=true)
     */
    private $wheelsDiameter = null;

    /**
     * @var int
     *
     * @ORM\Column(name="mileage_from", type="integer", nullable=true)
     */
    private $mileageFrom = null;

    /**
     * @var int
     *
     * @ORM\Column(name="mileage_to", type="integer", nullable=true)
     */
    private $mileageTo = null;

    /**
     * @var int
     *
     * @ORM\Column(name="next_check_year", type="integer", nullable=true)
     */
    private $nextCheckYear = null;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Country", fetch="LAZY")
     * @ORM\JoinTable(name="searches_first_countries")
     */
    private $firstCountry;

    /**
     * @var int
     *
     * @ORM\Column(name="gears_number", type="integer", nullable=true)
     */
    private $gearsNumber = null;

    /**
     * @var int
     *
     * @ORM\Column(name="last_ad_update", type="integer", nullable=true)
     */
    private $lastAdUpdate;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_type", type="integer", nullable=true)
     */
    private $sortType;

    /**
     * Vehicle constructor.
     */
    public function __construct()
    {
        $this->bodyType = new ArrayCollection();
        $this->city = new ArrayCollection();
        $this->climateControl = new ArrayCollection();
        $this->color = new ArrayCollection();
        $this->defects = new ArrayCollection();
        $this->firstCountry = new ArrayCollection();
        $this->fuelType = new ArrayCollection();
        $this->model = new ArrayCollection();
        $this->provider = new ArrayCollection();
        $this->transmission = new ArrayCollection();
    }

    /**
     * Get id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get provider
     */
    public function getProvider(): Collection
    {
        return $this->provider;
    }

    /**
     * Set price from
     */
    public function setPriceFrom(int $price = null): VehicleSearch
    {
        $this->priceFrom = $price;

        return $this;
    }

    /**
     * Get price from
     */
    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    /**
     * Set price to
     */
    public function setPriceTo(int $price = null): VehicleSearch
    {
        $this->priceTo = $price;

        return $this;
    }

    /**
     * Get price to
     */
    public function getPriceTo()
    {
        return $this->priceTo;
    }

    /**
     * Set year from
     */
    public function setYearFrom(int $year = null): VehicleSearch
    {
        $this->yearFrom = $year;

        return $this;
    }

    /**
     * Get year from
     */
    public function getYearFrom()
    {
        return $this->yearFrom;
    }

    /**
     * Set year to
     */
    public function setYearTo(int $year = null): VehicleSearch
    {
        $this->yearTo = $year;

        return $this;
    }

    /**
     * Get year to
     */
    public function getYearTo()
    {
        return $this->yearTo;
    }

    /**
     * Set engineSize from
     */
    public function setEngineSizeFrom(int $engineSize = null): VehicleSearch
    {
        $this->engineSizeFrom = $engineSize;

        return $this;
    }

    /**
     * Get engineSize from
     */
    public function getEngineSizeFrom()
    {
        return $this->engineSizeFrom;
    }

    /**
     * Set engineSize to
     */
    public function setEngineSizeTo(int $engineSize = null): VehicleSearch
    {
        $this->engineSizeTo = $engineSize;

        return $this;
    }

    /**
     * Get engineSize to
     */
    public function getEngineSizeTo()
    {
        return $this->engineSizeTo;
    }

    /**
     * Set power from
     */
    public function setPowerFrom(int $power = null): VehicleSearch
    {
        $this->powerFrom = $power;

        return $this;
    }

    /**
     * Get power from
     */
    public function getPowerFrom()
    {
        return $this->powerFrom;
    }

    /**
     * Set power to
     */
    public function setPowerTo(int $power = null): VehicleSearch
    {
        $this->powerTo = $power;

        return $this;
    }

    /**
     * Get power to
     */
    public function getPowerTo()
    {
        return $this->powerTo;
    }


    /**
     * Set doorsNumber
     */
    public function setDoorsNumber(int $doorsNumber = null): VehicleSearch
    {
        $this->doorsNumber = $doorsNumber;

        return $this;
    }

    /**
     * Get doorsNumber
     */
    public function getDoorsNumber()
    {
        return $this->doorsNumber;
    }

    /**
     * Set seatsNumber
     */
    public function setSeatsNumber(int $seatsNumber = null): VehicleSearch
    {
        $this->seatsNumber = $seatsNumber;

        return $this;
    }

    /**
     * Get seatsNumber
     */
    public function getSeatsNumber()
    {
        return $this->seatsNumber;
    }

    /**
     * Set driveType
     */
    public function setDriveType(int $driveType = null): VehicleSearch
    {
        $this->driveType = $driveType;

        return $this;
    }

    /**
     * Get driveType
     */
    public function getDriveType()
    {
        return $this->driveType;
    }

    /**
     * Set steeringWheel
     */
    public function setSteeringWheel(int $steeringWheel = null): VehicleSearch
    {
        $this->steeringWheel = $steeringWheel;

        return $this;
    }

    /**
     * Get steeringWheel
     */
    public function getSteeringWheel()
    {
        return $this->steeringWheel;
    }

    /**
     * Set wheelsDiameter
     */
    public function setWheelsDiameter(int $wheelsDiameter = null): VehicleSearch
    {
        $this->wheelsDiameter = $wheelsDiameter;

        return $this;
    }

    /**
     * Get wheelsDiameter
     */
    public function getWheelsDiameter()
    {
        return $this->wheelsDiameter;
    }

    /**
     * Set mileage from
     */
    public function setMileageFrom(int $mileage = null): VehicleSearch
    {
        $this->mileageFrom = $mileage;

        return $this;
    }

    /**
     * Get mileage from
     */
    public function getMileageFrom()
    {
        return $this->mileageFrom;
    }

    /**
     * Set mileage to
     */
    public function setMileageTo(int $mileage = null): VehicleSearch
    {
        $this->mileageTo = $mileage;

        return $this;
    }

    /**
     * Get mileage to
     */
    public function getMileageTo()
    {
        return $this->mileageTo;
    }


    /**
     * Set brand
     */
    public function setBrand(Brand $brand = null): VehicleSearch
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Get model
     */
    public function getModel(): Collection
    {
        return $this->model;
    }

    /**
     * Set country
     */
    public function setCountry(Country $country = null): VehicleSearch
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get city
     */
    public function getCity(): Collection
    {
        return $this->city;
    }

    /**
     * Get bodyType
     */
    public function getBodyType(): Collection
    {
        return $this->bodyType;
    }

    /**
     * Get fuelType
     */
    public function getFuelType(): Collection
    {
        return $this->fuelType;
    }

    /**
     * Get color
     */
    public function getColor(): Collection
    {
        return $this->color;
    }

    /**
     * Get transmission
     */
    public function getTransmission(): Collection
    {
        return $this->transmission;
    }

    /**
     * Get climateControl
     */
    public function getClimateControl(): Collection
    {
        return $this->climateControl;
    }

    /**
     * Get defects
     */
    public function getDefects(): Collection
    {
        return $this->defects;
    }

    /**
     * Set nextCheckYear
     */
    public function setNextCheckYear(int $nextCheckYear = null): VehicleSearch
    {
        $this->nextCheckYear = $nextCheckYear;

        return $this;
    }

    /**
     * Get nextCheckYear
     */
    public function getNextCheckYear()
    {
        return $this->nextCheckYear;
    }

    /**
     * Set gearsNumber
     */
    public function setGearsNumber(int $gearsNumber = null): VehicleSearch
    {
        $this->gearsNumber = $gearsNumber;

        return $this;
    }

    /**
     * Get gearsNumber
     */
    public function getGearsNumber()
    {
        return $this->gearsNumber;
    }

    /**
     * Set lastAdUpdate
     */
    public function setLastAdUpdate(int $lastAdUpdate = null): VehicleSearch
    {
        $this->lastAdUpdate = $lastAdUpdate;

        return $this;
    }

    /**
     * Get lastAdUpdate
     */
    public function getLastAdUpdate()
    {
        return $this->lastAdUpdate;
    }

    /**
     * Get firstCountry
     */
    public function getFirstCountry(): Collection
    {
        return $this->firstCountry;
    }

    /**
     * Set sort type
     */
    public function setSortType(int $sortType = null): VehicleSearch
    {
        $this->sortType = $sortType;

        return $this;
    }

    /**
     * Get sort type
     */
    public function getSortType()
    {
        return $this->sortType;
    }

    /**
     * Add provider
     */
    public function addProvider(Provider $provider): VehicleSearch
    {
        $this->provider[] = $provider;

        return $this;
    }

    /**
     * Remove provider
     */
    public function removeProvider(Provider $provider)
    {
        $this->provider->removeElement($provider);
    }

    /**
     * Add model
     */
    public function addModel(Model $model): VehicleSearch
    {
        $this->model[] = $model;

        return $this;
    }

    /**
     * Remove model
     */
    public function removeModel(Model $model)
    {
        $this->model->removeElement($model);
    }

    /**
     * Add city
     */
    public function addCity(City $city): VehicleSearch
    {
        $this->city[] = $city;

        return $this;
    }

    /**
     * Remove city
     */
    public function removeCity(City $city)
    {
        $this->city->removeElement($city);
    }

    /**
     * Add bodyType
     */
    public function addBodyType(BodyType $bodyType): VehicleSearch
    {
        $this->bodyType[] = $bodyType;

        return $this;
    }

    /**
     * Remove bodyType
     */
    public function removeBodyType(BodyType $bodyType)
    {
        $this->bodyType->removeElement($bodyType);
    }

    /**
     * Add fuelType
     */
    public function addFuelType(FuelType $fuelType): VehicleSearch
    {
        $this->fuelType[] = $fuelType;

        return $this;
    }

    /**
     * Remove fuelType
     */
    public function removeFuelType(FuelType $fuelType)
    {
        $this->fuelType->removeElement($fuelType);
    }

    /**
     * Add transmission
     */
    public function addTransmission(Transmission $transmission): VehicleSearch
    {
        $this->transmission[] = $transmission;

        return $this;
    }

    /**
     * Remove transmission
     */
    public function removeTransmission(Transmission $transmission)
    {
        $this->transmission->removeElement($transmission);
    }

    /**
     * Add climateControl
     */
    public function addClimateControl(ClimateControl $climateControl): VehicleSearch
    {
        $this->climateControl[] = $climateControl;

        return $this;
    }

    /**
     * Remove climateControl
     */
    public function removeClimateControl(ClimateControl $climateControl)
    {
        $this->climateControl->removeElement($climateControl);
    }

    /**
     * Add color
     */
    public function addColor(Color $color): VehicleSearch
    {
        $this->color[] = $color;

        return $this;
    }

    /**
     * Remove color
     */
    public function removeColor(Color $color)
    {
        $this->color->removeElement($color);
    }

    /**
     * Add defect
     */
    public function addDefect(Defects $defect): VehicleSearch
    {
        $this->defects[] = $defect;

        return $this;
    }

    /**
     * Remove defect
     */
    public function removeDefect(Defects $defect)
    {
        $this->defects->removeElement($defect);
    }

    /**
     * Add firstCountry
     */
    public function addFirstCountry(Country $firstCountry): VehicleSearch
    {
        $this->firstCountry[] = $firstCountry;

        return $this;
    }

    /**
     * Remove firstCountry
     */
    public function removeFirstCountry(Country $firstCountry)
    {
        $this->firstCountry->removeElement($firstCountry);
    }

    /**
     * Set user
     */
    public function setUser(User $user = null): VehicleSearch
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set pinned
     */
    public function setPinned(int $pinned): VehicleSearch
    {
        $this->pinned = $pinned;

        return $this;
    }

    /**
     * Get pinned
     */
    public function getPinned()
    {
        return $this->pinned;
    }
}
