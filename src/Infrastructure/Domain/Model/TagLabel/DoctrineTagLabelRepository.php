<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\TagLabel;

use XTags\App\Entity\EntityManager;
use XTags\App\Repository\LabelRepository as DoctrineRespository;
use XTags\App\Entity\Label as DoctrineEntity;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\TagLabel\{
    TagLabelRepository as DomainRepository,
    TagLabel as DomainModel,
    TagLabelCollection as DomainCollection
};
use XTags\Domain\Model\TagLabel\ValueObject\DefinitionId;
use XTags\Domain\Model\TagLabel\ValueObject\LabelId;
use XTags\Domain\Model\TagLabel\ValueObject\LabelName;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Shared\Domain\Model\ValueObject\Id;
use XTags\Shared\Domain\Model\ValueObject\Version;

class DoctrineTagLabelRepository extends EntityManager implements DomainRepository
{
    
    protected $doctrineRepository;

    public function __construct(DoctrineRespository $doctrineRepository )
    {
        $this->doctrineRepository = $doctrineRepository;
    }

    public function save(DomainModel $label): void 
    {
        $labelEntity = $this->modelToEntity($label, new DoctrineEntity());
        $this->saveEntity($labelEntity);
    }

    public function find(Id $id): DomainModel
    {
        $label = $this->doctrineRepository->find($id);

        if ($label) $label = $this->entityToModel($label);
        
        return $label;
    }

    public function findBy(array $criteria, array $opts): DomainCollection
    {
        $labels = $this->doctrineRepository->findBy($criteria, $opts);
        $output = [];

        if ($labels && count($labels) > 0 ) {
            foreach ($labels as $label) {
                $output[] = $this->entityToModel($label);
            }
        }
        return DomainCollection::from($output);
    }

    public function findAll(): DomainCollection 
    {
        $collection = [];
        $labels = $this->doctrineRepository->findAll();
        
        foreach ($labels as $label) {
            $collection[] = $this->entityToModel($label);
        }
        $labelCollection = DomainCollection::from($collection);
        return $labelCollection;
    }
    
    public function modelToEntity(DomainModel $labelModel, DoctrineEntity $labelEntity): DoctrineEntity
    {
        $labelEntity->setName($labelModel->name()->value());

        return $labelEntity;
    }

    public function entityToModel(DoctrineEntity $label): DomainModel
    { 
        $labelModel = DomainModel::from(
            LabelId::from($label->getId()), 
            LabelName::from($label->getName()), 
            LanguagesId::from($label->getLanguage()->getId()), 
            DefinitionId::from($label->getDefinitionId()[0]->getId()),
            VocabulariesId::from($label->getVocabulary()->getId()),
            Version::from($label->getVersion()),
            $label->getCreatedAt(),
            $label->getUpdatedAt()
        );

        return  $labelModel;
    }
}
