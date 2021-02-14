<?php

namespace AppBundle\Model;

class Vehicle
{

    /**
     * @var int
     */
    private $providerId = null;

    /**
     * @var string
     */
    private $provider;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $model;

    /**
     * @var int
     */
    private $price = null;

    /**
     * @var int
     */
    private $year = null;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $city;

    /**
     * @var int
     */
    private $engineSize = null;

    /**
     * @var string
     */
    private $bodyType;

    /**
     * @var int
     */
    private $power = null;

    /**
     * @var string
     */
    private $fuelType;

    /**
     * @var int
     */
    private $doorsNumber = null;

    /**
     * @var int
     */
    private $seatsNumber = null;

    /**
     * @var int
     */
    private $driveType = null;

    /**
     * @var string
     */
    private $transmission = null;

    /**
     * @var string
     */
    private $climateControl = null;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $defects = null;

    /**
     * @var int
     */
    private $steeringWheel = null;

    /**
     * @var int
     */
    private $wheelsDiameter = null;

    /**
     * @var int
     */
    private $weight = null;

    /**
     * @var int
     */
    private $mileage = null;

    /**
     * @var string
     */
    private $image = null;

    /**
     * @var int
     */
    private $nextCheckYear = null;

    /**
     * @var string
     */
    private $firstCountry = null;

    /**
     * @var int
     */
    private $gearsNumber = null;

    /**
     * @var \DateTime
     */
    private $lastAdUpdate;

    /**
     * @var \DateTime
     */
    private $lastCheck;

    /**
     * @param int $providerId
     * @return Vehicle
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * @param string $provider
     * @return Vehicle
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param int $price
     * @return Vehicle
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $year
     * @return Vehicle
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $engineSize
     * @return Vehicle
     */
    public function setEngineSize($engineSize)
    {
        $this->engineSize = $engineSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getEngineSize()
    {
        return $this->engineSize;
    }

    /**
     * @param int $power
     * @return Vehicle
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * @return int
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @param int $doorsNumber
     * @return Vehicle
     */
    public function setDoorsNumber($doorsNumber)
    {
        $this->doorsNumber = $doorsNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getDoorsNumber()
    {
        return $this->doorsNumber;
    }

    /**
     * @param int $seatsNumber
     * @return Vehicle
     */
    public function setSeatsNumber($seatsNumber)
    {
        $this->seatsNumber = $seatsNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getSeatsNumber()
    {
        return $this->seatsNumber;
    }

    /**
     * @param int $driveType
     * @return Vehicle
     */
    public function setDriveType($driveType)
    {
        $this->driveType = $driveType;

        return $this;
    }

    /**
     * @return int
     */
    public function getDriveType()
    {
        return $this->driveType;
    }

    /**
     * @param string $transmission
     * @return Vehicle
     */
    public function setTransmission($transmission)
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransmission()
    {
        return $this->transmission;
    }

    /**
     * @param string $climateControl
     * @return Vehicle
     */
    public function setClimateControl($climateControl)
    {
        $this->climateControl = $climateControl;

        return $this;
    }

    /**
     * @return string
     */
    public function getClimateControl()
    {
        return $this->climateControl;
    }

    /**
     * @param string $defects
     * @return Vehicle
     */
    public function setDefects($defects)
    {
        $this->defects = $defects;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefects()
    {
        return $this->defects;
    }

    /**
     * @param int $steeringWheel
     * @return Vehicle
     */
    public function setSteeringWheel($steeringWheel)
    {
        $this->steeringWheel = $steeringWheel;

        return $this;
    }

    /**
     * @return int
     */
    public function getSteeringWheel()
    {
        return $this->steeringWheel;
    }

    /**
     * @param int $wheelsDiameter
     * @return Vehicle
     */
    public function setWheelsDiameter($wheelsDiameter)
    {
        $this->wheelsDiameter = $wheelsDiameter;

        return $this;
    }

    /**
     * @return int
     */
    public function getWheelsDiameter()
    {
        return $this->wheelsDiameter;
    }

    /**
     * @param int $weight
     * @return Vehicle
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $mileage
     * @return Vehicle
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * @return int
     */
    public function getMileage()
    {
        return $this->mileage;
    }


    /**
     * @param string $brand
     * @return Vehicle
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $model
     * @return Vehicle
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $country
     * @return Vehicle
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $city
     * @return Vehicle
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $bodyType
     * @return Vehicle
     */
    public function setBodyType($bodyType)
    {
        $this->bodyType = $bodyType;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyType()
    {
        return $this->bodyType;
    }

    /**
     * @param string $fuelType
     * @return Vehicle
     */
    public function setFuelType($fuelType)
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    /**
     * @return string
     */
    public function getFuelType()
    {
        return $this->fuelType;
    }

    /**
     * @param string $color
     * @return Vehicle
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $link
     * @return Vehicle
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set image
     */
    public function setImage(string $image = null): Vehicle
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set nextCheckYear
     */
    public function setNextCheckYear(int $nextCheckYear = null): Vehicle
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
    public function setGearsNumber(int $gearsNumber = null): Vehicle
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
    public function setLastAdUpdate(\DateTime $lastAdUpdate = null): Vehicle
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
     * Set lastCheck
     */
    public function setLastCheck(\DateTime $lastCheck): Vehicle
    {
        $this->lastCheck = $lastCheck;

        return $this;
    }

    /**
     * Get lastCheck
     */
    public function getLastCheck(): \DateTime
    {
        return $this->lastCheck;
    }

    /**
     * Set firstCountry
     */
    public function setFirstCountry(string $firstCountry = null): Vehicle
    {
        $this->firstCountry = $firstCountry;

        return $this;
    }

    /**
     * Get firstCountry
     */
    public function getFirstCountry()
    {
        return $this->firstCountry;
    }
}
