<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model\Vocabularies;

use XTags\App\Entity\EntityManager;
use XTags\App\Entity\Vocabularies as EntityVocabularies;
use XTags\App\Repository\VocabulariesRepository as DoctrineRespository;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesName;
use Xtags\Domain\Model\Vocabularies\Vocabularies as VocabulariesModel;
use XTags\Domain\Model\Vocabularies\VocabulariesCollection;
use XTags\Domain\Model\Vocabularies\VocabulariesRepository as DomainRepository;
use XTags\Domain\Service\Vocabularies\AllVocabulariesFinder;
use XTags\Domain\Service\Vocabularies\ByIdVocabulariesFinder;
use XTags\Shared\Application\Service\GuzzleClient;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Id;
use XTags\Shared\Domain\Model\ValueObject\Url;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class DoctrineVocabulariesRespository extends EntityManager  implements DomainRepository
{
    protected $doctrineRepository;

    public function __construct(DoctrineRespository $doctrineRepository )
    {
        $this->doctrineRepository = $doctrineRepository;
    }

    public function save(VocabulariesModel $vocabulary): void 
    {
        $vocabulariesEntity = $this->modelToEntity($vocabulary, new EntityVocabularies());
        $this->saveEntity($vocabulariesEntity);
    }

    public function find(Id $id): VocabulariesModel
    {
        $vocabulary = $this->doctrineRepository->find($id);
        
        return $this->entityToModel($vocabulary);
    }

    public function findAll(): VocabulariesCollection 
    {
        $collection = [];
        $vocabulariess = $this->doctrineRepository->findAll();
        
        foreach ($vocabulariess as $vocabularies) {
            $collection[] = $this->entityToModel($vocabularies);
        }
        $vocabulariesCollection = VocabulariesCollection::from($collection);
        return $vocabulariesCollection;
    }

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

    public function modelToEntity(VocabulariesModel $vocabulariesModel, EntityVocabularies $vocabulariesEntity): EntityVocabularies
    {
        $vocabulariesEntity->setName($vocabulariesModel->name()->value());
        $vocabulariesEntity->setUrlVocabulary($vocabulariesModel->url_vocabulary()->value());
        $vocabulariesEntity->setUrlDefinitions($vocabulariesModel->url_definitions()->value());
        $vocabulariesEntity->setUrlSearch($vocabulariesModel->url_search()->value());
        $vocabulariesEntity->setCreatedAt($vocabulariesModel->created_at());
        $vocabulariesEntity->setUpdateAt($vocabulariesModel->update_at());
        $vocabulariesEntity->setVersion($vocabulariesModel->version()->value());

        return $vocabulariesEntity;
    }

    public function entityToModel(EntityVocabularies $vocabulary): VocabulariesModel
    { 
        $vocabulariesModel = VocabulariesModel::from(
            VocabulariesId::from($vocabulary->getId()),
            VocabulariesName::from($vocabulary->getName()), 
            Url::from($vocabulary->getUrlVocabulary()), 
            Url::from($vocabulary->getUrlDefinitions()), 
            Url::from($vocabulary->getUrlSearch()), 
            DateTimeInmutable::fromTimestamp($vocabulary->getCreatedAt()->getTimestamp()), 
            DateTimeInmutable::fromTimestamp($vocabulary->getUpdateAt()->getTimestamp()), 
            Version::from($vocabulary->getVersion())
        );

        return  $vocabulariesModel;
    }
}
