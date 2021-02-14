<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Model;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class LoadBrandModelData extends AbstractLoadData implements FixtureInterface
{
    protected $fileName = '/data/brands_models.yml';
    protected $fixturesName = 'cars';
    protected $entityClass = Brand::class;
    protected $relatedFixtureName = 'models';
    protected $relatedEntityClass = Model::class;

    public function load(ObjectManager $manager)
    {
        return $this->loadFixtures($manager);
    }

    public function setParent(Model $child, Brand $parent)
    {
        $child->setBrand($parent);
    }
}
