<?php

namespace XTags\App\Repository;

use XTags\App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function findByIdResource(string $resourceId, $version, $vocabularyId = null, $typeId = null)
    {
        $criteria = [
            'resource' => Uuid::fromString($resourceId),
            'version' => $version
        ];

        if (null !== $vocabularyId) $criteria['vocabulary'] = $vocabularyId; 
        if (null !== $typeId) $criteria['type'] = $typeId;

        return $this->findBy([
            'resource' => $resourceId
        ]);
    }

    public function deleteManyById(array $ids)
    {
        $query = $this->createQueryBuilder('t');
        $query->delete()
            ->where('t.id IN (:ids)')
            ->setParameter(
                ':ids', 
                array_map(function ($id) {
                    return $id->toBinary();
                },
                $ids
            ));
        $q = $query->getQuery();
        $q->execute();        
    }


    // /**
    //  * @return Tag[] Returns an array of Tag objects
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
    public function findOneBySomeField($value): ?Tag
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
