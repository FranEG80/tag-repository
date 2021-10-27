<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Vocabularies;

use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Vocabulary as DoctrineEntity;
use XTags\App\Repository\VocabularyRepository as DoctrineRepository;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesName;
use Xtags\Domain\Model\Vocabularies\{
    Vocabularies as DomainModel,
    VocabulariesCollection as DomainCollection,
    VocabulariesRepository as DomainRepository
};
use XTags\Shared\Application\Service\GuzzleClient;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Id;
use XTags\Shared\Domain\Model\ValueObject\Url;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class DoctrineVocabulariesRespository extends EntityManager  implements DomainRepository
{
    protected $doctrineRepository;

    public function __construct(DoctrineRepository $doctrineRepository )
    {
        $this->doctrineRepository = $doctrineRepository;
    }

    public function save(DomainModel $vocabulary): void 
    {
        $vocabularyEntity = $this->modelToEntity($vocabulary, new DoctrineEntity());
        $this->saveEntity($vocabularyEntity);
    }

    public function find(Id $id): DomainModel
    {
        $vocabulary = $this->doctrineRepository->find($id);
        
        return $this->entityToModel($vocabulary);
    }

    public function findByName(VocabulariesName $name, $version): ?DomainModel
    {
        $criteria = [
            'name' => $name->value()
        ];
        if (null !== $version) $criteria['version'] = $version;

        $vocabulary = $this->doctrineRepository->findOneBy($criteria);

        return $this->entityToModel($vocabulary);
    }

    public function findAll(): DomainCollection 
    {
        $collection = [];
        $vocabularies = $this->doctrineRepository->findAll();
        
        foreach ($vocabularies as $vocabulary) {
            $collection[] = $this->entityToModel($vocabulary);
        }
        $vocabulariesCollection = DomainCollection::from($collection);
        return $vocabulariesCollection;
    }
// TODO **************************************************************************
// TODO **************************************************************************
// TODO CHANGE TO SERVICES
// TODO **************************************************************************
// TODO **************************************************************************
    public function searchQuery(string $vocabulary, string $mode, string $query, string $langsearch, string $langlabel, bool $suggestions, $tag_id): array
    {
        $output = [];

        $vocabularies = [];
        if ($vocabulary == 'all') {
            $vocabularies = $this->findAll();
        }

        foreach ($vocabularies as $vocabulary ) {
            $vocabulary;
            $schema = [
                'id' => 'localname',
                'tag_name' => 'prefLabel',
                'lang' => 'lang',
                'vocaburaly' => 'vocab'
            ];
            $field = 'results';
            $url_search = $vocabulary->url_search()->value();
            if ($tag_id !== '') {
                $url_search = $vocabulary->url_definitions()->value();
                $url_search = str_replace('%%ximdex_tag_id%%', $tag_id, $url_search);
                $url_search = str_replace('%%ximdex_schema%%', 'ld%2Bjson', $url_search);
                $field = 'graph';
            }
            $url_search = str_replace('%%ximdex_lang%%', $langsearch, $url_search);
            $url_search = str_replace('%%ximdex_labellang%%', $langlabel, $url_search);
            $url_search = str_replace('%%ximdex_query%%', rawurlencode($query), $url_search);

            $output[] = GuzzleClient::get($url_search, [], $schema,  $field);

        }
        
        return $output;        
    }

// TODO **************************************************************************
// TODO **************************************************************************
// TODO **************************************************************************
// TODO **************************************************************************


    public function modelToEntity(DomainModel $vocabularyModel, DoctrineEntity $vocabularyEntity): DoctrineEntity
    {
        $vocabularyEntity->setName($vocabularyModel->name()->value());
        $vocabularyEntity->setUrl($vocabularyModel->url_vocabulary()->value());
        $vocabularyEntity->setDefinitionUrl($vocabularyModel->url_definitions()->value());
        $vocabularyEntity->setUrl($vocabularyModel->url_search()->value());
        $vocabularyEntity->setCreatedAt($vocabularyModel->created_at());
        $vocabularyEntity->setUpdatedAt($vocabularyModel->update_at());
        $vocabularyEntity->setVersion((string) $vocabularyModel->version()->value());


    
        // TODO **************************************************************************
        // TODO **************************************************************************
        // TODO add semanticSchema[] to entity
        // TODO **************************************************************************
        // TODO **************************************************************************
        // $vocabularyEntity->addSemanticSchema([]);

        // TODO **************************************************************************
        // TODO **************************************************************************
        // TODO **************************************************************************
        // TODO **************************************************************************


        return $vocabularyEntity;
    }

    public function entityToModel(DoctrineEntity $vocabulary): DomainModel
    { 
        $vocabularyModel = DomainModel::from(
            VocabulariesId::from($vocabulary->getId()),
            VocabulariesName::from($vocabulary->getName()), 
            Url::from($vocabulary->getUrl()), 
            Url::from($vocabulary->getDefinitionUrl()), 
            Url::from($vocabulary->getSearchUrl()), 
            DateTimeInmutable::fromTimestamp($vocabulary->getCreatedAt()->getTimestamp()), 
            DateTimeInmutable::fromTimestamp($vocabulary->getUpdatedAt()->getTimestamp()), 
            Version::from($vocabulary->getVersion())
            // TODO **************************************************************************
            // TODO **************************************************************************
            // TODO add semanticSchema[] to Model
            // TODO **************************************************************************
            // TODO **************************************************************************
            // $vocabularyEntity->addSemanticSchema([]);

            // TODO **************************************************************************
            // TODO **************************************************************************
            // TODO **************************************************************************
            // TODO **************************************************************************

        );

        return  $vocabularyModel;
    }

     
}
