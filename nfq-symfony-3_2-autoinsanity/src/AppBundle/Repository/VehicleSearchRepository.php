<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\VehicleSearch;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * VehicleSearchRepository
 */
class VehicleSearchRepository extends EntityRepository
{
    // maximum number of recent searches stored for one user
    const MAX_SEARCHES_PER_USER = 10;

    public function getRecentSearches(User $user)
    {
        return $this->getJoinedTablesQuery()
            ->where('s.user = :user')
            ->setParameter('user', $user)
            ->andWhere('s.pinned <> 1')
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(self::MAX_SEARCHES_PER_USER)
            ->getQuery()
            ->getResult();
    }

    public function getSavedSearches(User $user, int $page)
    {
        $query = $this->getJoinedTablesQuery()
            ->where('s.user = :user')
            ->setParameter('user', $user)
            ->andWhere('s.pinned = 1')
            ->orderBy('s.id', 'DESC');
        $paginator = VehicleRepository::createQueryPagination($query, $page, self::MAX_SEARCHES_PER_USER, true);
        $totalPagesCount = ceil(count($paginator) / self::MAX_SEARCHES_PER_USER);
        return [
            'vehicles' => $paginator->getIterator()->getArrayCopy(),
            'total_pages_count' => $totalPagesCount
        ];
    }

    public function getOutdatedSearches(User $user)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('s')
            ->from('AppBundle:VehicleSearch', 's')
            ->where('s.user = :user')
            ->setParameter('user', $user)
            ->andWhere('s.pinned <> 1')
            ->orderBy('s.id', 'DESC')
            ->setFirstResult(self::MAX_SEARCHES_PER_USER - 1) // +1 new advert
            ->getQuery()
            ->getResult();
    }
    /**
     * Generates database query that joins vehicle table with other related tables
     */
    private function getJoinedTablesQuery(): QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s, bra, mod, bod, cli, col, cou, cit, def, fue, pro, tra, fcou')
            ->from('AppBundle:VehicleSearch', 's')
            ->leftJoin('s.brand', 'bra')
            ->leftJoin('s.model', 'mod')
            ->leftJoin('s.bodyType', 'bod')
            ->leftJoin('s.climateControl', 'cli')
            ->leftJoin('s.color', 'col')
            ->leftJoin('s.country', 'cou')
            ->leftJoin('s.city', 'cit')
            ->leftJoin('s.defects', 'def')
            ->leftJoin('s.fuelType', 'fue')
            ->leftJoin('s.provider', 'pro')
            ->leftJoin('s.transmission', 'tra')
            ->leftJoin('s.firstCountry', 'fcou');
    }
}
