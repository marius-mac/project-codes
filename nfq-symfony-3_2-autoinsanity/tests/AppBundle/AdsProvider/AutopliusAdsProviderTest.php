<?php

namespace Tests\AppBundle\AdsProvider;

use AppBundle\AdsProvider\AutopliusAdsProvider;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class AutopliusAdsProviderTest extends TestCase
{
    /**
     * @dataProvider dateProvider
     */
    public function testParseDate($date, $result)
    {
        $entityManagerMock = $this->createMock(EntityManager::class);
        $autopliusProvider = new AutopliusAdsProvider($entityManagerMock, '');
        $this->assertEquals($result, $autopliusProvider->parseDate($date));
    }

    public function dateProvider()
    {
        return [
            '1 minute ago' => ['prieš 1 min. ', (new \DateTime())->setTimestamp(strtotime('-1 min')) ],
            '59 minute ago' => ['prieš 59 min. ', (new \DateTime())->setTimestamp(strtotime('-59 min')) ],
            '1 hour ago' => ['prieš 1 val. 0 min. ', (new \DateTime())->setTimestamp(strtotime('-1 hour')) ],
            '1 hour 1 minute ago' => ['prieš 1 val. 1 min. ', (new \DateTime())->setTimestamp(strtotime('-1 hour -1 min')) ],
            '1 hour 59 minutes ago' => ['prieš 1 val. 59 min. ', (new \DateTime())->setTimestamp(strtotime('-1 hour -59 min')) ],
            '2 hours ago' => ['prieš 2 val. ', (new \DateTime())->setTimestamp(strtotime('-2 hours')) ],
            '23 hours ago' => ['prieš 23 val. ', (new \DateTime())->setTimestamp(strtotime('-23 hours')) ],
            '1 day ago' => ['prieš 1 d. ', (new \DateTime())->setTimestamp(strtotime('-1 day')) ],
            '13 days ago' => ['prieš 13 d. ', (new \DateTime())->setTimestamp(strtotime('-13 days')) ],
            'March 30' => ['Kovo 30 d. ', (new \DateTime())->setTimestamp(strtotime('March 30')) ],
            '2015 December 1' => ['2015-12-01 ', (new \DateTime())->setTimestamp(strtotime('December 1 2015')) ],
        ];
    }
}
