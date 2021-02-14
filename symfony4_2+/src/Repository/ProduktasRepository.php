<?php

namespace App\Repository;

use App\Entity\Produktas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Produktas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produktas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produktas[]    findAll()
 * @method Produktas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduktasRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produktas::class);
    }

    // /**
    //  * @return Produktas[] Returns an array of Produktas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produktas
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
