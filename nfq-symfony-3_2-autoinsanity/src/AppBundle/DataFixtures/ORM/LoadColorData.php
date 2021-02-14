<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Color;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadColorData extends AbstractLoadData implements FixtureInterface
{
    protected $fileName = '/data/colors.yml';
    protected $fixturesName = 'colors';
    protected $entityClass = Color::class;

    public function load(ObjectManager $manager)
    {
        return $this->loadFixtures($manager);
    }
}
