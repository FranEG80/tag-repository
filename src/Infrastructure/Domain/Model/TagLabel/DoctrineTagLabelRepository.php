<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\TagLabel;

use Doctrine\ORM\EntityManagerInterface;
use XTags\App\Entity\EntityManager;
use XTags\App\Repository\LabelRepository as DoctrineRespository;
use XTags\App\Entity\Label as DoctrineEntity;
use XTags\Domain\Model\Definition\ValueObject\DefinitionId;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\TagLabel\{
    TagLabelRepository as DomainRepository,
    TagLabel as DomainModel,
    TagLabelCollection as DomainCollection
};
use XTags\Domain\Model\TagLabel\ValueObject\LabelId;
use XTags\Domain\Model\TagLabel\ValueObject\LabelName;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Id;
use XTags\Shared\Domain\Model\ValueObject\Version;

class DoctrineTagLabelRepository extends EntityManager implements DomainRepository
{
    
    protected $doctrineRepository;
    protected EntityManagerInterface $em;

    public function __construct(DoctrineRespository $doctrineRepository, EntityManagerInterface $em )
    {
        $this->doctrineRepository = $doctrineRepository;
        $this->em = $em;
    }

    public function save(DomainModel $label): void 
    {
        $labelEntity = $this->modelToEntity($label, new DoctrineEntity());
        $this->saveEntity($labelEntity, $this->em);
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


    public function findOneBy(array $criteria, array $opts): ?DomainModel
    {
        $label = $this->doctrineRepository->findOneBy($criteria, $opts);
        
        if ($label !== null ) return  $this->entityToModel($label);
        
        return null;
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

    public static function entityToModel(DoctrineEntity $label): DomainModel
    { 
        $labelModel = DomainModel::from(
            LabelId::from($label->getId()), 
            LabelName::from($label->getName()), 
            LanguagesId::from($label->getLanguage()->getId()), 
            DefinitionId::from($label->getDefinition()->getId()),
            VocabulariesId::from($label->getVocabulary()->getId()),
            Version::from($label->getVersion()),
            DateTimeInmutable::fromAnotherDateTime($label->getCreatedAt()),
            DateTimeInmutable::fromAnotherDateTime($label->getUpdatedAt())
        );

        return  $labelModel;
    }
}
