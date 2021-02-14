<?php

namespace AppBundle\AdsProvider;

use AppBundle\Entity\Provider;

abstract class AdsProvider
{
    protected $em;
    protected $imgDirectory;
    protected $provider;
    protected $link;
    protected $providerName;

    public function getNewAds(int $pageNumber, $maxLastCheck): array
    {
        $url = str_replace('%psl%', $pageNumber, $this->link);
        $html = $this->getHtml($url);
        $cars = $this->parseAdsPage($html, $maxLastCheck);
        return $cars;
    }

    abstract protected function parseAdsPage($html, $maxLastCheck);

    public function saveToModel($accessor, $car)
    {
        $vehicle = new \AppBundle\Model\Vehicle();
        $vehicle
            ->setBrand(
                $accessor->getValue($car, '[brand]')
            )
            ->setModel(
                $accessor->getValue($car, '[model]')
            )
            ->setCountry(
                $accessor->getValue($car, '[country]')
            )
            ->setCity(
                $accessor->getValue($car, '[city]')
            )
            ->setBodyType(
                $accessor->getValue($car, '[body_type]')
            )
            ->setFuelType(
                $accessor->getValue($car, '[fuel_type]')
            )
            ->setColor(
                $accessor->getValue($car, '[color]')
            )
            ->setProviderId(
                $accessor->getValue($car, '[providerId]')
            )
            ->setProvider($this->provider)
            ->setLink(
                $accessor->getValue($car, '[url]')
            )
            ->setPrice(
                $accessor->getValue($car, '[price]')
            )
            ->setYear(
                $accessor->getValue($car, '[year]')
            )
            ->setEngineSize(
                $accessor->getValue($car, '[engine][engine_size]')
            )
            ->setPower(
                $accessor->getValue($car, '[engine][power]')
            )
            ->setDoorsNumber(
                $accessor->getValue($car, '[doors_number]')
            )
            ->setSeatsNumber(
                $accessor->getValue($car, '[seats_number]')
            )
            ->setDriveType(
                $accessor->getValue($car, '[drive_type]')
            )
            ->setTransmission(
                $accessor->getValue($car, '[transmission]')
            )
            ->setClimateControl(
                $accessor->getValue($car, '[climate_control]')
            )
            ->setDefects(
                $accessor->getValue($car, '[defects]')
            )
            ->setSteeringWheel(
                $accessor->getValue($car, '[steering_wheel]')
            )
            ->setWheelsDiameter(
                $accessor->getValue($car, '[wheels_diameter]')
            )
            ->setWeight(
                $accessor->getValue($car, '[weight]')
            )
            ->setMileage(
                $accessor->getValue($car, '[mileage]')
            )
            ->setImage(
                $accessor->getValue($car, '[image]')
            )
            ->setGearsNumber(
                $accessor->getValue($car, '[gears_number]')
            )
            ->setNextCheckYear(
                $accessor->getValue($car, '[next_check]')
            )
            ->setFirstCountry(
                $accessor->getValue($car, '[first_country]')
            )
            ->setLastAdUpdate(
                $accessor->getValue($car, '[last_update]')
            );

        return $vehicle;
    }

    public function saveImages($imageUrl, $providerName, $id)
    {
        $fileName = $providerName . '-' . $id . '.jpg';
        $path = $this->imgDirectory . '/' . $fileName;
        $image = file_get_contents($imageUrl);
        $insert = file_put_contents($path, $image);
        if (!$insert) {
            throw new \Exception('Failed to write image');
        }
        return $fileName;
    }

    protected function getHtml($url)
    {
        $curl = curl_init($url);
        curl_setopt(
            $curl,
            CURLOPT_USERAGENT,
            "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) 
            Chrome/57.0.2987.133 Safari/537.36"
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        $html = curl_exec($curl);
        curl_close($curl);
        return $html;
    }

    protected function getFunctionFromKey(string $key)
    {
        $funcMap = [
            'year' => 'adParseYear',
            'engine' => 'adParseEngine',
            'engine_size' => 'adParseEngineSize',
            'engine_power' => 'adParseEnginePower',
            'fuel_type' => 'adParseFuelType',
            'body_type' => 'adParseBodyType',
            'color' => 'adParseColor',
            'drive_type' => 'adParseDriveType',
            'mileage' => 'adParseMileage',
            'transmission' => 'adParseTransmission',
            'defects' => 'adParseDefects',
            'steering_wheel' => 'adParseSteeringWheel',
            'doors_number' => 'adParseDoorsNumber',
            'gears_number' => 'adParseGearsNumber',
            'seats_number' => 'adParseSeatsNumber',
            'next_check' => 'adParseNextCheck',
            'weight' => 'adParseWeight',
            'first_country' => 'adParseFirstCountry',
            'wheels_diameter' => 'adParseWheelsDiameter',
            'climate_control' => 'adParseClimateControl',
        ];
        if (isset($funcMap[$key])) {
            return $funcMap[$key];
        } else {
            return null;
        }
    }

    public function getName(): string
    {
        return $this->providerName;
    }

    public function setProvider(Provider $provider): AdsProvider
    {
        $this->provider = $provider;
        return $this;
    }
}
