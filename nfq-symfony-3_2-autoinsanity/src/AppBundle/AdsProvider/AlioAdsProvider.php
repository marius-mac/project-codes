<?php

namespace AppBundle\AdsProvider;

use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AlioAdsProvider extends AdsProvider
{
    public function __construct(EntityManager $em, string $imgDirectory)
    {
        $this->em = $em;
        $this->imgDirectory = $imgDirectory;
        $this->link = 'http://www.alio.lt/paieska.html?category_id=613' .
            '&search_hash=28f73874e16073f2d48552657680cf215b5d6b84&page=%psl%';
        $this->providerName = 'Alio.lt';
    }

    protected function parseAdsPage($html, $maxLastCheck)
    {
        $cars = [];

        $crawler = new Crawler($html);
        $crawler = $crawler->filter('.result');

        foreach ($crawler as $domRow) {
            $row = new Crawler($domRow);

            $car = [];
            $lastUpdate = $row->filter('.uptodate');
            $lastUpdateDate = null;
            if ($lastUpdate->count() > 0) {
                $lastUpdateDate = $this->parseDate($lastUpdate->attr('datetime'));
            }
            if ($lastUpdateDate == null || $lastUpdateDate > $maxLastCheck) {
                $innerUrl = $row->filter('.showmobile')->attr('href');
                try {
                    $car = $this->parseAd($innerUrl);
                } catch (Exception $e) {
                    echo $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
                    echo "Link: " . $innerUrl . "\n\n";
                }
            }
            $car['last_update'] = $lastUpdateDate;
            $accessor = PropertyAccess::createPropertyAccessor();
            $vehicle = $this->saveToModel($accessor, $car);
            $cars[] = $vehicle;
            sleep(3);
        }
        return $cars;
    }

    private function parseAd(string $innerUrl)
    {
        $innerHtml = $this->getHtml($innerUrl);
        $innerCrawler = new Crawler($innerHtml);

        $temp = trim($innerCrawler->filter('#vertise_main_data_b h1')->text());
        $temp = explode(",", $temp);
        $carInfo = explode(" ", $temp[0]);

        $brand = $carInfo[0];
        $model = null;
        if (isset($carInfo[1])) {
            $model = $carInfo[1];
        }

        $brandModelRegex = '~(?<=[A-Za-z0-9])-(?=[A-Za-z0-9])~';
        $brand = preg_replace($brandModelRegex, ' ', $brand);
        $model = preg_replace($brandModelRegex, ' ', $model);

        $city = null;
        if (!empty($innerCrawler->filter('#vertise_main_data_b h2'))) {
            $city = trim($innerCrawler->filter('#vertise_main_data_b h2')->text());
        }
        $country = 'Lietuva';

        $price = trim($innerCrawler->filter('.data_price_aditional_b')->text());
        $price = intval(preg_replace('/[^0-9]+/', '', $price));

        $providerId = trim($innerCrawler->filter('#data_vertise_id_text_b')->text());
        $providerId = intval(preg_replace('/[^0-9]+/', '', $providerId));

        $car['image'] = null;
        if (!empty($imageElement = $innerCrawler->filter('#adv_photo_main > img')) && $imageElement->attr('src') !== null) {
            $imageUrl = trim($imageElement->attr('src'));
            $imageUrl = str_replace("_popup", "_large", $imageUrl);
            $car['image'] = $this->saveImages($imageUrl, $this->provider->getName(), $providerId);
        }

        $items = $innerCrawler->filterXPath('//div[contains(@class, "col_left")]//div[@class="data_moreinfo_b "]');

        foreach ($items as $innerDomRow) {
            $row = new Crawler($innerDomRow);
            $key = ($row->filterXPath('//div[@class="a_line_key"]')->count()) ?
                trim($row->filterXPath('//div[@class="a_line_key"]')->text()) :
                'Not set';
            $value = ($row->filterXPath('//div[@class="a_line_val"]')->count()) ?
                trim($row->filterXPath('//div[@class="a_line_val"]')->text()) :
                '';
            $key = $this->getKeyName($key);
            if ($key !== null) {
                $func = $this->getFunctionFromKey($key);
                $value = $this->$func($value);
                $car[$key] = $value;
            }
            $car[$key] = $value;
        }
        $cars[] = $car;
        $car = array_merge(
            $car, [
                    'brand' => $brand,
                    'model' => $model,
                    'city' => $city,
                    'country' => $country,
                    'url' => $innerUrl,
                    'price' => $price,
                    'providerId' => $providerId,
            ]
        );
        return $car;
    }
    public function parseDate(string $dateString): \DateTime
    {
        $date = new \DateTime();
        $dateString = str_replace("T", " ", $dateString);
        $dateString = explode("+", $dateString);
        $dateString = $dateString[0];
        $date->setTimestamp(strtotime($dateString));
        return $date;
    }

    protected function getKeyName(string $title)
    {
        $keyMap = [
            'Pagaminimo metai' => 'year',
            'Darbinis tūris' => 'engine_size',
            'Galia' => 'engine_power',
            'Kuro tipas' => 'fuel_type',
            'Kėbulo tipas' => 'body_type',
            'Spalva' => 'color',
            'Pavarų dėžė' => 'drive_type',
            'Rida' => 'mileage',
            'Varomieji ratai' => 'transmission',
            'Defektai' => 'defects',
            'Vairo padėtis' => 'steering_wheel',
            'Durų skaičius' => 'doors_number',
            'Pavarų skaičius' => 'gears_number',
            'Sėdimų vietų skaičius' => 'seats_number',
            'Pirmosios registracijos šalis' => 'first_country',
            'Ratlankiai' => 'wheels_diameter',
        ];
        if (isset($keyMap[$title])) {
            return $keyMap[$title];
        } else {
            return null;
        }
    }

    protected function adParseYear($value)
    {
        $dummy = explode("-", $value);
        $dummy = intval(preg_replace("/[^0-9,.]/", "", $dummy[0]));
        $value = intval($dummy);
        return $value;
    }

    protected function adParseEngineSize($value)
    {
        $dummy = $value;
        $value = [];
        $dummy = floatval(preg_replace("/[^0-9,.]/", "", $dummy));
        $dummy = intval($dummy * 1000);
        $value['engine_size'] = $dummy;
        return $value;
    }

    protected function adParseEnginePower($value)
    {
        $dummy = $value;
        $value = [];
        $power = null;
        preg_match('~\((.*?)\)~', $dummy, $power);
        $power = intval(preg_replace("/[^0-9,.]/", "", $power[1]));
        $value['power'] = $power;
        return $value;
    }

    protected function adParseFuelType($value)
    {
        if ($value == 'Benzinas - Dujos') {
            return 'Benzinas / dujos';
        }
        if ($value == 'Benzinas - Elektra') {
            return 'Benzinas / elektra';
        }
        if ($value == 'Dyzelinas/Elektra') {
            return 'Dyzelinas / elektra';
        }
        if ($value == 'Benzinas/Gamtinės dujos') {
            return 'Benzinas / gamtinės dujos';
        }
        if ($value == 'Etanolis') {
            return 'Bioetanolis (E85)';
        }
        return $value;
    }

    protected function adParseBodyType($value)
    {
        if ($value == 'Kupė') {
            return 'Kupė (Coupe)';
        }
        if ($value == 'Kabrioletas' || $value == 'Kabrioletas/Rodsteris') {
            return 'Kabrioletas / Roadster';
        }
        return $value;
    }

    protected function adParseColor($value)
    {
        if ($value == 'Raudona' || $value == 'Raudona/Vyšninė') {
            return 'Raudona / vyšninė';
        }
        if ($value == 'Žalia') {
            return 'Žalia / chaki';
        }

        return $value;
    }

    protected function adParseDriveType($value)
    {
        if ($value == 'Mechaninė') {
            return 0;
        }
        if ($value == 'Automatinė') {
            return 1;
        }
        if ($value == 'Pusiau automatinė') {
            return 1;
        }
        return null;
    }

    protected function adParseMileage($value)
    {
        $value = intval(preg_replace("/[^0-9,.]/", "", $value));
        return $value;
    }

    protected function adParseTransmission($value)
    {
        if ($value == 'Visi') {
            return 'Visi varantys (4х4)';
        }
        return null;
    }

    protected function adParseDefects($value)
    {
        return $value;
    }

    protected function adParseSteeringWheel($value)
    {
        if ($value == 'Kairėje') {
            return 0;
        }
        if ($value == 'Dešinėje (iš UK)') {
            return 1;
        }
        return null;
    }

    protected function adParseGearsNumber($value)
    {
        return $value;
    }

    protected function adParseDoorsNumber($value)
    {
        if ($value == 'Kita') {
            return null;
        }
        $firstNum = $secondNum = null;
        sscanf($value, "%d/%d", $firstNum, $secondNum);
        $value = $firstNum;
        return $value;
    }

    protected function adParseSeatsNumber($value)
    {
        $value = intval($value);
        return $value;
    }

    protected function adParseNextCheck($value)
    {
        $dummy = explode('-', $value);
        $value = intval($dummy[0]);
        return $value;
    }
}
