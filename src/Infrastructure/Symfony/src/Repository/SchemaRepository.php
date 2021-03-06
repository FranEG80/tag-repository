<?php

namespace XTags\App\Repository;

use XTags\App\Entity\Schema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Schema|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schema|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schema[]    findAll()
 * @method Schema[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchemaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schema::class);
    }

    // /**
    //  * @return Schema[] Returns an array of Schema objects
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
    public function findOneBySomeField($value): ?Schema
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
