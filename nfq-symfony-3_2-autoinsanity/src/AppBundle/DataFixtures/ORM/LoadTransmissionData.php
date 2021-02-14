<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Transmission;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTransmissionData extends AbstractLoadData implements FixtureInterface
{
    protected $fileName = '/data/transmissions.yml';
    protected $fixturesName = 'transmissions';
    protected $entityClass = Transmission::class;

    public function load(ObjectManager $manager)
    {
        return $this->loadFixtures($manager);
    }
}
