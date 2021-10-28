<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\ResourceTags;

use Doctrine\ORM\EntityManagerInterface;
use XTags\App\Entity\Resource as DoctrineEntity;
use XTags\App\Repository\ResourceRepository as DoctrineRepository;
use XTags\App\Repository\TagRepository;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\ResourceTags\ResourceTagsCollection as DomainCollection;
use XTags\Domain\Model\ResourceTags\ResourceTagsRepository as DomainRepository;
use XTags\Domain\Model\ResourceTags\ResourceTags as DomainModel;
use XTags\App\Entity\EntityManager;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalResourceId;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class DoctrineResourceTagsRepository extends EntityManager implements DomainRepository
{
    private DoctrineRepository $doctrineRepository;
    private TagRepository $tagRepository;
    private EntityManagerInterface $em;

    public function __construct(DoctrineRepository $doctrineRepository, TagRepository $tagRepository, EntityManagerInterface $em)
    {
        $this->doctrineRepository = $doctrineRepository;
        $this->tagRepository = $tagRepository;
        $this->em = $em;
    }
    
    public function find(ResourceTagId $id): ?DomainModel
    {
        $resource = $this->doctrineRepository->find($id->value());

        if ($resource) $resource = $this->entityToModel($resource);

        return $resource;
    }

    public function findByIdResource(ExternalResourceId $resourceTagsId, Version $version = null): ?DomainModel
    {
        if (null === $version) $version = Version::from(DomainModel::CURRENT_VERSION_RESOURCE_TAG);
        $resource = $this->doctrineRepository->findByExternalResourceId($resourceTagsId->value(), $version->value());

        if ($resource) $resource = $this->entityToModel($resource);

        return $resource;
    }

    public function save(DomainModel $resource): void 
    {
        $resource = $this->modelToEntity($resource);
        $this->saveEntity($resource, $this->em);
    }

    public function findAll(): DomainCollection
    {
        $collection = [];
        $resourceTagss = $this->doctrineRepository->findAll();
        
        foreach ($resourceTagss as $resource) {
            $collection[] = $this->entityToModel($resource);
        }
        $resourceTagsCollection = DomainCollection::from($collection);
        return $resourceTagsCollection;
    }

    private function modelToEntity(DomainModel $resourceTagModel): DoctrineEntity
    {
        $entity = new DoctrineEntity();
        $entity->setExternalId($resourceTagModel->resourceId()->value());
        $entity->setVersion($resourceTagModel->version()->value());
        $entity->setCreatedAt($resourceTagModel->createdAt());
        $entity->setUpdatedAt($resourceTagModel->updatedAt());
        $entity->setExternalSystemId($resourceTagModel->externalSystem()->value());

        return $entity;
    }

    private function entityToModel(DoctrineEntity $resource): DomainModel
    { 
        $resourceTagsModel = DomainModel::from(
            ResourceTagId::from($resource->getId()->toRfc4122()),
            ExternalResourceId::from($resource->getExternalId()->toRfc4122()),
            Version::from($resource->getVersion()),
            DateTimeInmutable::fromAnotherDateTime($resource->getCreatedAt()),
            DateTimeInmutable::fromAnotherDateTime($resource->getUpdatedAt())
        );

        return  $resourceTagsModel;
    }
}

