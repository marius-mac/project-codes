<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\FuelType;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFuelTypeData extends AbstractLoadData implements FixtureInterface
{
    protected $fileName = '/data/fuel_types.yml';
    protected $fixturesName = 'fuel_types';
    protected $entityClass = FuelType::class;

    public function load(ObjectManager $manager)
    {
        return $this->loadFixtures($manager);
    }
}
