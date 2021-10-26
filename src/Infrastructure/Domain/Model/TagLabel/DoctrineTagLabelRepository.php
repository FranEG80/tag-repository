<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\TagLabel;

use XTags\App\Entity\EntityManager;
use XTags\App\Repository\TagLabelRepository as DoctrineRespository;
use XTags\Domain\Model\TagLabel\TagLabelRepository as DomainRepository;
use XTags\App\Entity\TagLabel as EntityTagLabel;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelId;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelName;
use Xtags\Domain\Model\TagLabel\TagLabel as TagLabelModel;
use XTags\Domain\Model\TagLabel\TagLabelCollection;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Shared\Domain\Model\ValueObject\Id;
use XTags\Shared\Domain\Model\ValueObject\Version;

class DoctrineTagLabelRepository extends EntityManager implements DomainRepository
{
    
    protected $doctrineRepository;

    public function __construct(DoctrineRespository $doctrineRepository )
    {
        $this->doctrineRepository = $doctrineRepository;
    }

    public function save(TagLabelModel $tagLabel): void 
    {
        $tagLabelEntity = $this->modelToEntity($tagLabel, new EntityTagLabel());
        $this->saveEntity($tagLabelEntity);
    }

    public function find(Id $id): TagLabelModel
    {
        $tagLabel = $this->doctrineRepository->find($id);
        
        return $this->entityToModel($tagLabel);
    }

    public function findBy(array $criteria, array $opts): TagLabelCollection
    {
        $tagLabels = $this->doctrineRepository->findBy($criteria, $opts);
        $output = [];

        if ($tagLabels && count($tagLabels) > 0 ) {
            foreach ($tagLabels as $tagLabel) {
                $output[] = $this->entityToModel($tagLabel);
            }
        }
        return TagLabelCollection::from($output);
    }

    public function findAll(): TagLabelCollection 
    {
        $collection = [];
        $tagLabels = $this->doctrineRepository->findAll();
        
        foreach ($tagLabels as $tagLabel) {
            $collection[] = $this->entityToModel($tagLabel);
        }
        $tagLabelCollection = TagLabelCollection::from($collection);
        return $tagLabelCollection;
    }
    
    public function modelToEntity(TagLabelModel $tagLabelModel, EntityTagLabel $tagLabelEntity): EntityTagLabel
    {
        $tagLabelEntity->setName($tagLabelModel->name()->value());

        return $tagLabelEntity;
    }

    public function entityToModel(EntityTagLabel $tagLabel): TagLabelModel
    { 
        $tagLabelModel = TagLabelModel::from(
            TagLabelId::from($tagLabel->getId()),
            TagId::from($tagLabel->getTags()->getId()->value()),
            TagLabelName::from($tagLabel->getName()),
            LanguagesId::from($tagLabel->getLang()->getId()),
            Version::from($tagLabel->getVersion())
        );

        return  $tagLabelModel;
    }
}
