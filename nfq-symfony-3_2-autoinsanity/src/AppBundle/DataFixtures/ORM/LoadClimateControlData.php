<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ClimateControl;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadClimateControlDataData extends AbstractLoadData implements FixtureInterface
{
    protected $fileName = '/data/climate_controls.yml';
    protected $fixturesName = 'climate_controls';
    protected $entityClass = ClimateControl::class;

    public function load(ObjectManager $manager)
    {
        return $this->loadFixtures($manager);
    }
}
