<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Tags;

use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Tag as DoctrineEntity;
use XTags\App\Repository\ResourceRepository as DoctrineResourceRespository;
use XTags\App\Repository\LabelRepository as DoctrineLabelRespository;
use XTags\App\Repository\TagRepository as DoctrineRespository;
use XTags\App\Repository\TypeRepository as DoctrinTypeRepository;
use XTags\App\Repository\VocabularyRepository as DoctrineVocabularyRepository;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use Xtags\Domain\Model\Tags\{
    Tags as DomainModel,
    TagsCollection as DomainCollection,
    TagsRepository as DomainRepository
};
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Tags\ValueObject\TagName;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Version;

class DoctrineTagsRepository extends EntityManager implements DomainRepository
{
   
    protected $doctrineRepository;
    protected $resourceDomainRepository;
    protected $tagLabelRepository;
    protected $tagLabelRtypesRepositoryepository;

    public function __construct(
        DoctrineRespository $doctrineRepository,
        DoctrineResourceRespository $resourceDomainRepository,
        DoctrineLabelRespository $tagLabelRepository,
        DoctrinTypeRepository $typesRepository,
        DoctrineVocabularyRepository $vocabularyRepository 
    )
    {
        $this->doctrineRepository = $doctrineRepository;
        $this->resourceDomainRepository = $resourceDomainRepository;
        $this->tagLabelRepository = $tagLabelRepository;
        $this->typesRepository = $typesRepository;
        $this->vocabularyRepository = $vocabularyRepository;
    }

    public function save(DomainModel $tags): void 
    {
        $tagsEntity = $this->modelToEntity($tags);
        $this->saveEntity($tagsEntity);
    }

    public function find(TagId $id): DomainModel
    {
        $tag = $this->doctrineRepository->find($id);
        if ($tag) $tag = $this->entityToModel($tag);
        return $tag;
    }

    public function findAll(): DomainCollection 
    {
        $collection = [];
        $tags = $this->doctrineRepository->findAll();
        
        foreach ($tags as $tag) {
            $collection[] = $this->entityToModel($tag);
        }
        
        return DomainCollection::from($collection);
    }

    public function findAllByResourceId($id, $version): DomainCollection
    {
        $collection = [];
        if (null === $version) $version = Version::from(DomainModel::CURRENT_VERSION_TAG);
        $tags = $this->doctrineRepository->findByIdResource($id, $version);

        return DomainCollection::from($collection);
    }
    
    private function modelToEntity(DomainModel $tagsModel): DoctrineEntity
    {
        $entity = new DoctrineEntity();
        
        $resource = $this->resourceDomainRepository->find($tagsModel->resourceId());
        $vocabulary = $this->vocabularyRepository->find($tagsModel->vocabularyId());
        $type = $this->typesRepository->find($tagsModel->typeId());
        $entity->setName($tagsModel->customName()->value());
        $entity->setResource($resource);
        $entity->setType($type);
        $entity->setVocabulary($vocabulary);
        $entity->setVersion($tagsModel->version()->value());
        $entity->setUpdatedAt($tagsModel->createdAt());
        $entity->setCreatedAt($tagsModel->updatedAt());

// TODO labels?
        // $labels = $this->tagLabelRepository->find($tagsModel->));
        // $entity->addLabel($labels);

        return $entity;
    }

    private function entityToModel(DoctrineEntity $tags): DomainModel
    { 
        $tagsModel = DomainModel::from(
            TagId::from((string ) $tags->getId()),
            TagName::from($tags->getName()),
            ResourceTagId::from($tags->getResource()[0]->getId()),
            VocabulariesId::from($tags->getVocabulary()->getId()),
            TypesId::from($tags->getType()->getId()),
            DateTimeInmutable::from((string) $tags->getCreatedAt()),
            DateTimeInmutable::from((string) $tags->getUpdatedAt()),
            Version::from($tags->getVersion())
        );

        return  $tagsModel;
    }
}
