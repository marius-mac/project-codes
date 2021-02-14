<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Defects;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDefectsData extends AbstractLoadData implements FixtureInterface
{
    protected $fileName = '/data/defects.yml';
    protected $fixturesName = 'defects';
    protected $entityClass = Defects::class;

    public function load(ObjectManager $manager)
    {
        return $this->loadFixtures($manager);
    }
}
