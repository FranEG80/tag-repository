<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Languages;

use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Language as DoctrineEntity;
use XTags\App\Repository\LanguageRepository as DoctrineRespository;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\Languages\ValueObject\LanguagesName;
use Xtags\Domain\Model\Languages\Languages as DomainModel;
use XTags\Domain\Model\Languages\LanguagesCollection as DomainCollection;
use XTags\Domain\Model\Languages\LanguagesRepository as DomainRepository;
use XTags\Shared\Domain\Model\ValueObject\Id;

final class DoctrineLanguagesRespository extends EntityManager implements DomainRepository
{
    protected $doctrineRepository;

    public function __construct(DoctrineRespository $doctrineRepository)
    {
        $this->doctrineRepository = $doctrineRepository;
    }

    public function save(DomainModel $language): void 
    {
        $languageEntity = $this->modelToEntity($language, new DoctrineEntity());
        $this->saveEntity($languageEntity);
    }

    public function find(Id $id): DomainModel
    {
        $language = $this->doctrineRepository->find($id);
        
        if ($language) $language = $this->entityToModel($language);

        return $language;
    }

    public function findAll(): DomainCollection
    {
        $collection = [];
        $languages = $this->doctrineRepository->findAll();
        
        foreach ($languages as $language) {
            $collection[] = $this->entityToModel($language);
        }
        $languageCollection = DomainCollection::from($collection);
        return $languageCollection;

    }

    public function modelToEntity(DomainModel $languageModel, DoctrineEntity $languageEntity): DoctrineEntity
    {
        $languageEntity->setName($languageModel->name()->value());

        return $languageEntity;
    }

    public function entityToModel(DoctrineEntity $language): DomainModel
    {
        $languageModel = DomainModel::from(
            LanguagesId::from($language->getId()),
            LanguagesName::from($language->getName())
        );

        return  $languageModel;
    }
}
