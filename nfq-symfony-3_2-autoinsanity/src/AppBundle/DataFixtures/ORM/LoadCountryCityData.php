<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\City;
use AppBundle\Entity\Country;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class LoadCountryCityData extends AbstractLoadData implements FixtureInterface
{
    protected $fileName = '/data/countries_cities.yml';
    protected $fixturesName = 'countries';
    protected $entityClass = Country::class;
    protected $relatedFixtureName = 'cities';
    protected $relatedEntityClass = City::class;

    public function load(ObjectManager $manager)
    {
        return $this->loadFixtures($manager);
    }

    public function setParent(City $child, Country $parent)
    {
        $child->setCountry($parent);
    }
}
