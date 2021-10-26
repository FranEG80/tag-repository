<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\ResourceTags;

use XTags\App\Entity\ResourceTags as EntityResourceTags;
use XTags\App\Repository\ResourceTagsRepository as DoctrineRepository;
use XTags\App\Repository\TagsRepository;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\ResourceTags\{
    ResourceTagsCollection, 
    ResourceTagsRepository, 
    ResourceTags as ResourceTagsModel
};
use XTags\App\Entity\EntityManager;

final class DoctrineResourceTagsRepository extends EntityManager implements ResourceTagsRepository
{
    private $doctrineRepository;
    private $tagsRepository;

    public function __construct(DoctrineRepository $doctrineRepository, TagsRepository $tagsRepository)
    {
        $this->doctrineRepository = $doctrineRepository;
        $this->tagsRepository = $tagsRepository;
    }
    
    public function find(ResourceTagId $resourceTagsId): ?ResourceTagsModel
    {
        $resourceTagsEntity = $this->doctrineRepository->findOneBy(
            array('resource_id' => $resourceTagsId),
            array('name' => 'ASC'),
            1, 0
        );
        return $this->entityToModel($resourceTagsEntity);
    }

    public function save(ResourceTagsModel $resourceTags): void 
    {
        $resourceTagsEntity = $this->modelToEntity($resourceTags, new EntityResourceTags());
        $this->saveEntity($resourceTagsEntity);
    }

    public function findAll(): ResourceTagsCollection
    {
        $collection = [];
        $resourceTagss = $this->doctrineRepository->findAll();
        
        foreach ($resourceTagss as $resourceTags) {
            $collection[] = $this->entityToModel($resourceTags);
        }
        $resourceTagsCollection = ResourceTagsCollection::from($collection);
        return $resourceTagsCollection;
    }

    public function modelToEntity(
        ResourceTagsModel $resourceTagsModel, 
        EntityResourceTags $resourceTagsEntity
    ): EntityResourceTags
    {
        $tag = $this->tagsRepository->find($resourceTagsModel->tagId());
        $resourceTagsEntity->setTags($tag);

        return $resourceTagsEntity;
    }

    public function entityToModel(EntityResourceTags $resourceTagsEntity): ResourceTagsModel
    { 
        $resourceTagsModel = ResourceTagsModel::from(
            ResourceTagId::from((string) $resourceTagsEntity->getResourceId()),
            TagId::from((string) $resourceTagsEntity->getTags()),
            $resourceTagsEntity->getCreatedAt(),
            $resourceTagsEntity->getUpdateAt(),
        );

        return  $resourceTagsModel;
    }
}

