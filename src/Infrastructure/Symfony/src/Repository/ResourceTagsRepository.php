<?php

namespace XTags\App\Repository;

use XTags\App\Entity\ResourceTags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResourceTags|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResourceTags|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResourceTags[]    findAll()
 * @method ResourceTags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceTagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResourceTags::class);
    }

    // /**
    //  * @return ResourceTags[] Returns an array of ResourceTags objects
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
    public function findOneBySomeField($value): ?ResourceTags
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
