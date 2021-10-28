<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Definition;

use Doctrine\ORM\EntityManagerInterface;
use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Definition as EntityDefinition;
use XTags\App\Repository\DefinitionRepository as DoctrineRespository;
use XTags\Domain\Model\Definition\ValueObject\DefinitionId;
use Xtags\Domain\Model\Definition\Definition as DomainModel;
use XTags\Domain\Model\Definition\Definition;
use XTags\Domain\Model\Definition\DefinitionCollection as DomainCollection;
use XTags\Domain\Model\Definition\DefinitionRepository as DomainRepository;
use XTags\Domain\Model\Definition\ValueObject\DefinitionName;

final class DoctrineDefinitionRepository extends EntityManager implements DomainRepository
{
    protected $doctrineRepository;
    protected $em;

    public function __construct(DoctrineRespository $doctrineRepository, EntityManagerInterface $em)
    {
        $this->doctrineRepository = $doctrineRepository;
        $this->em = $em;
    }

    public function save(DomainModel $types): void 
    {
        $typesEntity = $this->modelToEntity($types, new EntityDefinition());
        $this->saveEntity($typesEntity, $this->em);
    }

    public function find(DefinitionId $id): DomainModel
    {
        $type = $this->doctrineRepository->find($id);

        if ($type) $type = $this->entityToModel($type);

        return $type;
    }

    public function findByName(DefinitionName $definition): ?Definition
    {
        $definition = $this->doctrineRepository->findOneBy([
            'name' => $definition->value()
        ], []);
        if (null !== $definition) return $definition = $this->entityToModel($definition);
        
        return $definition;
    }


    public function findAll(): DomainCollection
    {
        $collection = [];
        $typess = $this->doctrineRepository->findAll();
        
        foreach ($typess as $types) {
            $collection[] = $this->entityToModel($types);
        }
        $typesCollection = DomainCollection::from($collection);
        return $typesCollection;

    }

    public function modelToEntity(DomainModel $typesModel, EntityDefinition $typesEntity): EntityDefinition
    {
        $typesEntity->setName($typesModel->name()->value());

        return $typesEntity;
    }

    public function entityToModel(EntityDefinition $types): DomainModel
    { 
        $typesModel = DomainModel::from(
            DefinitionId::from($types->getId()),
            DefinitionName::from($types->getName())
        );

        return  $typesModel;
    }
}
