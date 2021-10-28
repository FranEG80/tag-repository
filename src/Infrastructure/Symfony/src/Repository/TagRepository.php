<?php

namespace XTags\App\Repository;

use XTags\App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
            'resource' => $resourceId,
            'version' => $version
        ];

        if (null !== $vocabularyId) $criteria['vocabulary'] = $vocabularyId; 
        if (null !== $typeId) $criteria['type'] = $typeId;

        return $this->findBy($criteria);
    }

    public function deleteManyById(array $ids)
    {
        $query = $this->createQueryBuilder('t');
        $query->delete('t')
            ->where('id in (:ids)')
            ->setParameter(':ids', array($ids));
        
        return $query->getQuery();
    }

    // /**
    //  * @return Tag[] Returns an array of Tag objects
    //  */
    /*
    public function findByExampleField(string $resourceId, $version, $vocabularyId = null, $typeId = null)
    {
        $query = $this->createQueryBuilder('t');

        $query->andWhere('t.version = :version')->setParameter('version', $version);
        $query->andWhere('t.resource = :resource')->setParameter('resource', $resourceId);
                
        if ($vocabularyId) {
            $query->andWhere('t.vocabulary = :vocabulary')->setParameter('vocabulary', $vocabularyId);
        }

        if ($typeId) {
            $query->andWhere('t.type = :type')->setParameter('type', $typeId);
        }

        return $query->getQuery()->getResult();
    }
    */

    /*
    public function findByIdResource($value): ?Tag
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
