<?php

namespace XTags\App\Repository;

use XTags\App\Entity\Vocabularies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vocabularies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vocabularies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vocabularies[]    findAll()
 * @method Vocabularies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VocabulariesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vocabularies::class);
    }

    // /**
    //  * @return Vocabularies[] Returns an array of Vocabularies objects
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
    public function findOneBySomeField($value): ?Vocabularies
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
