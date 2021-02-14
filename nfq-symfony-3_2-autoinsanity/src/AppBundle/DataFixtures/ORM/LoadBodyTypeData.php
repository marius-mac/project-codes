<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\BodyType;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBodyTypeData extends AbstractLoadData implements FixtureInterface
{
    protected $fileName = '/data/body_types.yml';
    protected $fixturesName = 'body_types';
    protected $entityClass = BodyType::class;

    public function load(ObjectManager $manager)
    {
        return $this->loadFixtures($manager);
    }
}
