<?php
namespace AppBundle\Command;

use AppBundle\AdsProvider\AdsProvider;
use AppBundle\Model\Vehicle;
use AppBundle\Entity\Vehicle as VehicleEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StartCrawlerCommand extends Command
{
    private $adsProviders;
    private $em;
    private $imgDirectory;

    public function __construct(array $adsProviders, EntityManager $em, string $imgDirectory)
    {
        parent::__construct();

        $this->adsProviders = $adsProviders;
        $this->em = $em;
        $this->imgDirectory = $imgDirectory;
    }

    protected function configure()
    {
        $this->setName('crawler:start')
            ->setDescription('Start a crawler');
        $this->addOption('update', null, InputOption::VALUE_NONE,
            "Browses only these ads that were updated after the last date found on the database");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!is_dir($this->imgDirectory)) {
            mkdir($this->imgDirectory);
        }
        $maxLastCheck = (new \DateTime())->setTimestamp(strtotime("1970-01-01"));
        if ($input->getOption('update')) {
            $query = $this->em->createQueryBuilder()
                ->select('MAX(v.lastCheck) AS maxLastCheck')
                ->from('AppBundle:Vehicle', 'v');
            try {
                $lastCheckResult = $query->getQuery()->getSingleScalarResult();
                if ($lastCheckResult == null) {
                    $maxLastCheck = (new \DateTime())->setTimestamp(strtotime("1970-01-01"));
                } else {
                    $maxLastCheck = (new \DateTime())->setTimestamp(strtotime($lastCheckResult));
                }
            } catch (NoResultException $e) {
                $maxLastCheck->setTimestamp(strtotime("1970-01-01"));
            }
        }
        $startingTime = new \DateTime();
        foreach ($this->adsProviders as $adsProvider) {
            $crawlerManager = new $adsProvider($this->em, $this->imgDirectory);

            echo "Starting " . $crawlerManager->getName() . "\n";

            $provider = $this->em->getRepository("AppBundle:Provider")->findOneBy(
                ['name' => $crawlerManager->getName()]
            );
            $crawlerManager->setProvider($provider);
            $pageNumber = 1;
            $ads = [];
            while ($pageNumber == 1 || !empty($ads)) {
                $ads = $crawlerManager->getNewAds($pageNumber, $maxLastCheck);
                foreach ($ads as $ad) {
                    $this->save($ad);
                }
                $this->em->flush();
                echo "(Page " . $pageNumber . ") Saved to database " . count($ads) . " entries.\n";

                $pageNumber++;
            }
            if ($input->getOption('update')) {
                echo "Deleting expired ads\n";
                // delete not found vehicles
                $this->em->createQueryBuilder()
                    ->delete('AppBundle:Vehicle', 'v')
                    ->where('v.lastCheck < :time')
                    ->setParameter('time', $startingTime)
                    ->andWhere('v.provider = :provider')
                    ->setParameter('provider', $provider)
                    ->getQuery()
                    ->execute();
            }
            echo "Finishing " . $adsProvider->getName() . "\n";
        }
    }

    private function save(Vehicle $ad)
    {
        $em = $this->em;
        $relations = [];
        $relationsMap = [
            'brand' => [
                'AppBundle:Brand',
                ['name' => $ad->getBrand()],
            ],
            'country' => [
                'AppBundle:Country',
                ['name' => $ad->getCountry(),],
            ],
            'body_type' => [
                'AppBundle:BodyType',
                ['name' => $ad->getBodyType(),],
            ],
            'fuel_type' => [
                'AppBundle:FuelType',
                ['name' => $ad->getFuelType(),],
            ],
            'color' => [
                'AppBundle:Color',
                ['name' => $ad->getColor(),],
            ],
            'defects' => [
                'AppBundle:Defects',
                ['name' => $ad->getDefects(),],
            ],
            'transmission' => [
                'AppBundle:Transmission',
                ['name' => $ad->getTransmission(),],
            ],
            'climate_control' => [
                'AppBundle:ClimateControl',
                ['name' => $ad->getClimateControl(),],
            ],
            'first_country' => [
                'AppBundle:Country',
                ['name' => $ad->getFirstCountry(),],
            ],
        ];
        $firstRelations = $this->resolveFields($relationsMap, $ad->getLink());
        if ($firstRelations == null) {
            return 0;
        }
        $relations = array_merge($relations, $firstRelations);
        $dependedRelationsMap = [
            'model' => [
                'AppBundle:Model',
                ['name' => $ad->getModel(), 'brand' => $relations['brand'],],
            ],
            'city' => [
                'AppBundle:City',
                ['name' => $ad->getCity(), 'country' => $relations['country'],],
            ],
        ];
        $secondRelations = $this->resolveFields($dependedRelationsMap, $ad->getLink());
        if ($secondRelations == null) {
            return 0;
        }
        $relations = array_merge($relations, $secondRelations);

        if ($ad->getProviderId() == null || $ad->getPrice() == null) {
            return 0;
        }

        // update vehicle if it already exists
        $repository = $em->getRepository("AppBundle:Vehicle");
        $vehicle = $repository->findOneBy(
            [
            'provider' => $ad->getProvider(),
            'providerId' => $ad->getProviderId(),
            ]
        );
        // if not found, create new
        if ($vehicle == null) {
            $vehicle = new VehicleEntity();
        }

        $vehicle->setBrand($relations['brand']);
        $vehicle->setModel($relations['model']);
        $vehicle->setCountry($relations['country']);
        $vehicle->setCity($relations['city']);
        $vehicle->setBodyType($relations['body_type']);
        $vehicle->setFuelType($relations['fuel_type']);
        $vehicle->setColor($relations['color']);
        $vehicle->setProviderId($ad->getProviderId());
        $vehicle->setProvider($ad->getProvider());
        $vehicle->setLink($ad->getLink());
        $vehicle->setPrice($ad->getPrice());
        $vehicle->setYear($ad->getYear());
        $vehicle->setEngineSize($ad->getEngineSize());
        $vehicle->setPower($ad->getPower());
        $vehicle->setDoorsNumber($ad->getDoorsNumber());
        $vehicle->setSeatsNumber($ad->getSeatsNumber());
        $vehicle->setDriveType($ad->getDriveType());
        $vehicle->setTransmission($relations['transmission']);
        $vehicle->setClimateControl($relations['climate_control']);
        $vehicle->setDefects($relations['defects']);
        $vehicle->setSteeringWheel($ad->getSteeringWheel());
        $vehicle->setWheelsDiameter($ad->getWheelsDiameter());
        $vehicle->setWeight($ad->getWeight());
        $vehicle->setMileage($ad->getMileage());
        $vehicle->setImage($ad->getImage());
        $vehicle->setNextCheckYear($ad->getNextCheckYear());
        $vehicle->setFirstCountry($relations['first_country']);
        $vehicle->setGearsNumber($ad->getGearsNumber());
        $vehicle->setLastAdUpdate($ad->getLastAdUpdate());
        $vehicle->setLastCheck(new \DateTime());
        $em->persist($vehicle);
        return 1;
    }

    private function resolveFields($fieldsMap, $link)
    {
        $relations = [];
        foreach ($fieldsMap as $key => $relationMap) {
            $relations[$key] = $this->findOneInRepository($relationMap[0], $relationMap[1]);
            if ($relations[$key] == null && !empty($relationMap[1]['name'])) {
                echo "Skipped: Failed to find element in " . $relationMap[0]
                    . " with parameters: " . $relationMap[1]['name']
                    . "\n"
                    . "Ad link: " . $link . "\n\n";
                return null;
            }
        }
        return $relations;
    }

    private function findOneInRepository(string $repository, array $params)
    {
        $repository = $this->em->getRepository($repository);
        $item = $repository->findOneBy($params);
        // when search was unsuccessful, try to mark as "Other" category
        if ($item == null) {
            $params['name'] = '-kita-';
            $item = $repository->findOneBy($params);
        }
        return $item;
    }
}
