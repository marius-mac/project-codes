<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractLoadData
{
    protected $fileName;
    protected $fixturesName;
    protected $entityClass;
    protected $relatedFixtureName;
    protected $relatedEntityClass;

    abstract public function load(ObjectManager $manager);

    public function loadFixtures(ObjectManager $manager)
    {
        try {
            $itemsData = $this->parseData();
            foreach ($itemsData[$this->fixturesName] as $itemData) {
                $item = new $this->entityClass();
                $item->setName($itemData['name']);
                $manager->persist($item);
                if (isset($itemData[$this->relatedFixtureName])) {
                    foreach ($itemData[$this->relatedFixtureName] as $relatedItemName) {
                        $relatedItem = new $this->relatedEntityClass();
                        $relatedItem->setName($relatedItemName);
                        $this->setParent($relatedItem, $item);
                        $manager->persist($relatedItem);
                    }
                }
                $manager->flush();
            }
            return 0;
        } catch (ParseException $e) {
            printf("Unable to parse the YAML file: %s", $e->getMessage());
            return 1;
        }
    }

    private function parseData(): array
    {
        $itemsData = Yaml::parse(file_get_contents(__DIR__ . $this->fileName));
        return $itemsData;
    }
}
