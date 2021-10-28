<?php

namespace XTags\Infrastructure\Entrypoint\Controller\ResourceTagsController\Get;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Query\Languages\GetAllLanguages\GetAllLanguagesQuery;
use XTags\Application\Query\Languages\GetByIdLanguage\GetByIdLanguageQuery;
use XTags\Application\Query\Languages\GetByNameLanguage\GetByNameLanguageQuery;
use XTags\Application\Query\ResourceTags\GetByIdResourceTag\GetByIdResourceTagQuery;
use XTags\Application\Query\Tags\GetAllTagsByIdResource\GetAllTagsByIdResourceQuery;
use XTags\Application\Query\Vocabularies\GetAllVocabularies\GetAllVocabulariesQuery;
use XTags\Application\Query\Vocabularies\GetByIdVocabulary\GetByIdVocabularyQuery;
use XTags\Application\Query\Vocabularies\GetByNameVocabulary\GetByNameVocabularyQuery;
use XTags\Domain\Model\Languages\Languages;
use XTags\Domain\Model\Languages\LanguagesCollection;
use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Model\Vocabularies\Vocabularies;

class GetResourceTagsController extends AbstractController
{    
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $output = ['data' => []];

        $resourceId = $request->query->get('id');
        $language = $request->query->get('language');
        $vocabulary = $request->query->get('vocabulary');
        $type = $request->query->get('type');

        $version_tag = $request->query->get('tagv');
        $version_resource = $request->query->get('resourcev');
        $vocabulary_version = $request->query->get('vocababularyv');

        // Get Resource
        $resource = $this->getResource($resourceId, $version_resource); 
        $output = $resource->jsonSerialize();
        
        // Get ID vocabulary of id||name
        if (null !== $vocabulary) {
            $vocabulary = $this->getVocabulary($vocabulary, $vocabulary_version);
        }
        
        // Get ID language of id||name
        if (null !== $language) {
            $language = $this->getLanguage($language);
        }

        // Get Tags with labels
        $output['tags'] = $this->getTags($resource, $version_tag, $vocabulary, $type, $language);

        return new JsonResponse($output, Response::HTTP_OK);
    }

    private function getResource($resourceId, $version_resource): ?ResourceTags
    {
        if ($version_resource) $version_resource = (string) $version_resource;
        return $this->handle(
            GetByIdResourceTagQuery::create($resourceId, $version_resource)
        );
    }

    private function getVocabulary($value, $vocabulary_version): ?Vocabularies
    {
        if (is_numeric($value) ) {
            return $this->handle(
                GetByIdVocabularyQuery::create(intval($value))
            );
        }
        return $this->handle(
            GetByNameVocabularyQuery::create($value, $vocabulary_version)
        );
    }

    private function getVocabularies()
    {
        return $this->handle(GetAllVocabulariesQuery::create());
    }
    
    private function getId($value): ?int
    {
        return null !== $value ? (int) $value->id()->value() : null;
    }

    private function getLanguage($language): ?Languages
    {
        if (is_numeric($language)) {
            return $this->handle(GetByIdLanguageQuery::create(intval($language)));
        }

        return $this->handle(GetByNameLanguageQuery::create($language));
    }

    private function getLanguages(): LanguagesCollection
    {
        return $this->handle(GetAllLanguagesQuery::create());
    }

    private function getTags($resource, $version_tag, $vocab, $type, $lang): array
    {
        if ($version_tag) $version_tag = (string) $version_tag;

        $tags = [];
        $tagsCollection = $this->handle(
            GetAllTagsByIdResourceQuery::create(
                $resource->id()->value(),
                $version_tag,
                $this->getId($vocab),
                $type
            )
        );

        $languages = null !== $this->getId($lang) ? $lang : $this->getLanguages();
        $vocabularies = null !== $this->getId($vocab) ? $vocab : $this->getVocabularies();

        // Get Labels
        foreach ($tagsCollection as $tag) {
            $tagWithLabels = $tag->jsonSerialize();
            $definition = $tag->definitionId()->value();
            // get labels with langs
            $tagWithLabels['labels'] = [];

            foreach ($tag->labels as $label) {
                if (!$this->isEqualOrNull($this->getId($vocab), $label->vocabularyId()->value())) continue;
                if (!$this->isEqualOrNull($this->getId($lang), $label->langId()->value())) continue;
                
                $vocabulary = null !== $this->getId($vocab)
                    ? $vocabularies
                    : $vocabularies->filter(fn($_vocabulary) => $this->getId($_vocabulary) == $label->vocabularyId()->value())->first();

                if (!$tag->vocabularyId()->equalTo($vocabulary->id())) continue;

                $language = null !== $this->getId($lang)
                    ? $languages
                    : $languages->filter(fn($language) => $this->getId($language) == $label->langId()->value())->first();

                $label = $label->jsonSerialize();

                $label['language'] = $language->name();
                $label['vocabulary'] = $vocabulary->name();

                $tagWithLabels['labels'][$definition][] =  $label;
                
            }
            $tags[] = $tagWithLabels;
        }
        return $tags;
    }

    private function isEqualOrNull($id, $otherId)
    {
        return $id === null || $otherId === null || ($id === $otherId);
    }
}
