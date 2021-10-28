<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Types;

use Doctrine\ORM\EntityManagerInterface;
use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Type as EntityTypes;
use XTags\App\Repository\TypeRepository as DoctrineRespository;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Types\ValueObject\TypesName;
use Xtags\Domain\Model\Types\Types as DomainModel;
use XTags\Domain\Model\Types\TypesCollection as DomainCollection;
use XTags\Domain\Model\Types\TypesRepository as DomainRepository;
use XTags\Shared\Domain\Model\ValueObject\Id;

final class DoctrineTypesRepository extends EntityManager implements DomainRepository
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
        $typesEntity = $this->modelToEntity($types, new EntityTypes());
        $this->saveEntity($typesEntity, $this->em);
    }

    public function find(Id $id): DomainModel
    {
        $type = $this->doctrineRepository->find($id);

        if ($type) $type = $this->entityToModel($type);

        return $type;
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

    public function modelToEntity(DomainModel $typesModel, EntityTypes $typesEntity): EntityTypes
    {
        $typesEntity->setName($typesModel->name()->value());

        return $typesEntity;
    }

    public function entityToModel(EntityTypes $types): DomainModel
    { 
        $typesModel = DomainModel::from(
            TypesId::from($types->getId()),
            TypesName::from($types->getName())
        );

        return  $typesModel;
    }
}
