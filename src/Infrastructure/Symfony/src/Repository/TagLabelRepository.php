<?php

namespace XTags\App\Repository;

use XTags\App\Entity\TagLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TagLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagLabel[]    findAll()
 * @method TagLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagLabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TagLabel::class);
    }

    // /**
    //  * @return TagLabel[] Returns an array of TagLabel objects
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
    public function findOneBySomeField($value): ?TagLabel
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
