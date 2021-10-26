<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Types;

use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Types as EntityTypes;
use XTags\App\Repository\TypesRepository as DoctrineRespository;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Types\ValueObject\TypesName;
use Xtags\Domain\Model\Types\Types as TypesModel;
use XTags\Domain\Model\Types\TypesCollection;
use XTags\Domain\Model\Types\TypesRepository as DomainRepository;
use XTags\Shared\Domain\Model\ValueObject\Id;

final class DoctrineTypesRepository extends EntityManager implements DomainRepository
{
    protected $doctrineRepository;

    public function __construct(DoctrineRespository $doctrineRepository)
    {
        $this->doctrineRepository = $doctrineRepository;
    }

    public function save(TypesModel $types): void 
    {
        $typesEntity = $this->modelToEntity($types, new EntityTypes());
        $this->saveEntity($typesEntity);
    }

    public function find(Id $id): TypesModel
    {
        $types = $this->doctrineRepository->find($id);
        
        return $this->entityToModel($types);
    }

    public function findAll(): TypesCollection
    {
        $collection = [];
        $typess = $this->doctrineRepository->findAll();
        
        foreach ($typess as $types) {
            $collection[] = $this->entityToModel($types);
        }
        $typesCollection = TypesCollection::from($collection);
        return $typesCollection;

    }

    public function modelToEntity(TypesModel $typesModel, EntityTypes $typesEntity): EntityTypes
    {
        $typesEntity->setName($typesModel->name()->value());

        return $typesEntity;
    }

    public function entityToModel(EntityTypes $types): TypesModel
    { 
        $typesModel = TypesModel::from(
            TypesId::from($types->getId()),
            TypesName::from($types->getName())
        );

        return  $typesModel;
    }
}
