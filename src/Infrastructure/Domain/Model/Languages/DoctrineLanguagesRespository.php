<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Languages;

use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Languages as EntityLanguages;
use XTags\App\Repository\LanguagesRepository as DoctrineRespository;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\Languages\ValueObject\LanguagesName;
use Xtags\Domain\Model\Languages\Languages as LanguagesModel;
use XTags\Domain\Model\Languages\LanguagesCollection;
use XTags\Domain\Model\Languages\LanguagesRepository as DomainRepository;
use XTags\Shared\Domain\Model\ValueObject\Id;

final class DoctrineLanguagesRespository extends EntityManager implements DomainRepository
{
    protected $doctrineRepository;

    public function __construct(DoctrineRespository $doctrineRepository)
    {
        $this->doctrineRepository = $doctrineRepository;
    }

    public function save(LanguagesModel $languages): void 
    {
        $languagesEntity = $this->modelToEntity($languages, new EntityLanguages());
        $this->saveEntity($languagesEntity);
    }

    public function find(Id $id): LanguagesModel
    {
        $languages = $this->doctrineRepository->find($id);
        
        return $this->entityToModel($languages);
    }

    public function findAll(): LanguagesCollection
    {
        $collection = [];
        $languagess = $this->doctrineRepository->findAll();
        
        foreach ($languagess as $languages) {
            $collection[] = $this->entityToModel($languages);
        }
        $languagesCollection = LanguagesCollection::from($collection);
        return $languagesCollection;

    }

    public function modelToEntity(LanguagesModel $languagesModel, EntityLanguages $languagesEntity): EntityLanguages
    {
        $languagesEntity->setName($languagesModel->name()->value());

        return $languagesEntity;
    }

    public function entityToModel(EntityLanguages $languages): LanguagesModel
    { 
        $languagesModel = LanguagesModel::from(
            LanguagesId::from($languages->getId()),
            LanguagesName::from($languages->getName())
        );

        return  $languagesModel;
    }
}
