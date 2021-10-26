<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Tags;

use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Tags as EntityTags;
use XTags\App\Repository\ResourceTagsRepository;
use XTags\App\Repository\TagLabelRepository;
use XTags\App\Repository\TagsRepository as DoctrineRespository;
use XTags\App\Repository\TypesRepository;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelId;
use XTags\Domain\Model\TagLabel\ValueObject\TagName;
use Xtags\Domain\Model\Tags\Tags as TagsModel;
use XTags\Domain\Model\Tags\TagsCollection;
use XTags\Domain\Model\Tags\TagsRepository as DomainRepository;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Version;

class DoctrineTagsRepository extends EntityManager implements DomainRepository
{
   
    protected $doctrineRepository;
    protected $resourceTagsRepository;
    protected $tagLabelRepository;
    protected $tagLabelRtypesRepositoryepository;

    public function __construct(
        DoctrineRespository $doctrineRepository,
        ResourceTagsRepository $resourceTagsRepository,
        TagLabelRepository $tagLabelRepository,
        TypesRepository $typesRepository
    )
    {
        $this->doctrineRepository = $doctrineRepository;
        $this->resourceTagsRepository = $resourceTagsRepository;
        $this->tagLabelRepository = $tagLabelRepository;
        $this->typesRepository = $typesRepository;
    }

    public function save(TagsModel $tags): void 
    {
        $tagsEntity = $this->modelToEntity($tags, new EntityTags());
        $this->saveEntity($tagsEntity);
    }

    public function find(TagId $id): TagsModel
    {
        $tags = $this->doctrineRepository->find($id);
        
        return $this->entityToModel($tags);
    }

    public function findAll(): TagsCollection 
    {
        $collection = [];
        $tagss = $this->doctrineRepository->findAll();
        
        foreach ($tagss as $tags) {
            $collection[] = $this->entityToModel($tags);
        }
        $tagsCollection = TagsCollection::from($collection);
        return $tagsCollection;
    }
    
    public function modelToEntity(TagsModel $tagsModel, EntityTags $tagsEntity): EntityTags
    {
        $label = $this->tagLabelRepository->find($tagsModel->tagLabelId());
        $resource = $this->resourceTagsRepository->find($tagsModel->resourceId());
        $type = $this->typesRepository->find($tagsModel->typeId());
        $tagsEntity->setTagName($tagsModel->customName()->value());
        $tagsEntity->addResource($resource);
        $tagsEntity->addLabel($label);
        $tagsEntity->setVersion((int) $tagsModel->version());
        $tagsEntity->setCreatedAt($tagsModel->createdAt());
        $tagsEntity->setUpdateAt($tagsModel->updatedAt());
        $tagsEntity->setType($type);


        return $tagsEntity;
    }

    public function entityToModel(EntityTags $tags): TagsModel
    { 
        $tagsModel = TagsModel::from(
            TagId::from((string ) $tags->getId()),
            TagName::from($tags->getCustomName()),
            TagLabelId::from($tags->getLabel()[0]->getId()),
            ResourceTagId::from($tags->getResource()[0]->getId()),
            VocabulariesId::from($tags->getVocabulary()->getId()),
            TypesId::from($tags->getType()->getId()),
            DateTimeInmutable::from((string) $tags->getCreatedAt()),
            DateTimeInmutable::from((string) $tags->getUpdateAt()),
            Version::from($tags->getVersion())
        );

        return  $tagsModel;
    }
}
