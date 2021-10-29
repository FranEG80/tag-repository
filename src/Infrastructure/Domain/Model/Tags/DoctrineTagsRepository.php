<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Tags;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Tag as DoctrineEntity;
use XTags\App\Repository\TagRepository as DoctrineRespository;
use XTags\Domain\Model\ValueObject\DefinitionName;
use XTags\Infrastructure\Domain\Model\ResourceTags\DoctrineResourceTagsRepository as DoctrineResourceRespository;
use XTags\Infrastructure\Domain\Model\TagLabel\DoctrineTagLabelRepository as DoctrineLabelRespository;
use XTags\Infrastructure\Domain\Model\Types\DoctrineTypesRepository as DoctrineTypeRepository;
use XTags\Infrastructure\Domain\Model\Vocabularies\DoctrineVocabulariesRespository as DoctrineVocabularyRepository;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\{
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
    protected $em;

    public function __construct(
        DoctrineRespository $doctrineRepository,
        DoctrineResourceRespository $resourceDomainRepository,
        DoctrineLabelRespository $tagLabelRepository,
        DoctrineTypeRepository $typesRepository,
        DoctrineVocabularyRepository $vocabularyRepository,
        EntityManagerInterface $em
    )
    {
        $this->doctrineRepository = $doctrineRepository;
        $this->resourceDomainRepository = $resourceDomainRepository;
        $this->tagLabelRepository = $tagLabelRepository;
        $this->typesRepository = $typesRepository;
        $this->vocabularyRepository = $vocabularyRepository;
        $this->em = $em;
    }

    public function save(DomainModel $tags): void 
    {
        $tagsEntity = $this->modelToEntity($tags);
        $this->saveEntity($tagsEntity, $this->em);
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

    public function findBy($criteria, $opts = null): DomainCollection
    {
        $collection = [];
        $tags = $this->doctrineRepository->findBy($criteria, $opts);
        
        foreach ($tags as $tag) {
            $collection[] = $this->entityToModel($tag);
        }
        
        return DomainCollection::from($collection);
    }

    public function findAllByResourceId(
        ResourceTagId $id, 
        Version $version = null, 
        VocabulariesId $vocabularyId = null, 
        TypesId $typeId = null
    ): DomainCollection
    {
        $tagsCollection = [];
        if (null === $version) $version = Version::from(DomainModel::CURRENT_VERSION_TAG);
        if (null !== $vocabularyId) $vocabularyId = $vocabularyId->value();
        if (null !== $typeId) $typeId = $typeId->value();

        $tags = $this->doctrineRepository->findByIdResource($id->value(), $version->value(), $vocabularyId, $typeId);

        foreach ($tags as $tag) {
            // $tagWithLanguage = $this->entityToModel($tag);
            // // $labelsEntity = $tag->getLabels();
            // $labels = [];
            // foreach($labelsEntity as $label) {
            //     $labels[] = DoctrineLabelRespository::entityToModel($label);
            // }
            // $tagWithLanguage->labels = $labels;
            // $tagsCollection[] = $tagWithLanguage;
        }
        return DomainCollection::from($tagsCollection);
    }

    public function deleteManyById(array $ids): void
    {
        $deleteIds = [];
        foreach ($ids as $id) $deleteIds[] = $id instanceof TagId ? $id->value() : $id;

        $this->doctrineRepository->deleteManyById($deleteIds);

    }
    
    private function modelToEntity(DomainModel $tagsModel): DoctrineEntity
    {
        $entity = new DoctrineEntity();

        if (null !== $tagsModel->id()) $entity->setId(Uuid::fromString($tagsModel->id()->value()));    

        $entity->setName($tagsModel->customName()->value());

        $entity->setResource(Uuid::fromString($tagsModel->resourceId()->value()));
        $entity->setType($tagsModel->typeId()->value());
        $entity->setVocabulary((int) $tagsModel->vocabularyId()->value());
        $entity->setVersion($tagsModel->version()->value());
        $entity->setUpdatedAt($tagsModel->createdAt());
        $entity->setCreatedAt($tagsModel->updatedAt());
        $entity->setDefinition($tagsModel->definition()->value());

        return $entity;
    }

    private function entityToModel(DoctrineEntity $tags): DomainModel
    { 
        $tagsModel = DomainModel::from(
            TagId::from((string ) $tags->getId()),
            TagName::from($tags->getName()),
            DefinitionName::from($tags->getDefinition()),
            ResourceTagId::from($tags->getResource()->toRfc4122()),
            VocabulariesId::from($tags->getVocabulary()),
            TypesId::from($tags->getType()),
            DateTimeInmutable::fromAnotherDateTime($tags->getCreatedAt()),
            DateTimeInmutable::fromAnotherDateTime($tags->getUpdatedAt()),
            Version::from($tags->getVersion())
        );

        return  $tagsModel;
    }
}
