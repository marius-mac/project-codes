<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Provider;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProviderData extends AbstractLoadData implements FixtureInterface
{
    protected $fileName = '/data/providers.yml';
    protected $fixturesName = 'providers';
    protected $entityClass = Provider::class;

    public function load(ObjectManager $manager)
    {
        return $this->loadFixtures($manager);
    }
}
