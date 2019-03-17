<?php

namespace App\Repository;

use App\Entity\Airports;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Airports|null find($id, $lockMode = null, $lockVersion = null)
 * @method Airports|null findOneBy(array $criteria, array $orderBy = null)
 * @method Airports[]    findAll()
 * @method Airports[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirportsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Airports::class);
    }

    // /**
    //  * @return Airports[] Returns an array of Airports objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Airports
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
