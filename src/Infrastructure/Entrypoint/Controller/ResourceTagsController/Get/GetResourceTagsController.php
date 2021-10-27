<?php

namespace XTags\Infrastructure\Entrypoint\Controller\ResourceTagsController\Get;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Query\ResourceTags\GetByIdResourceTag\GetByIdResourceTagQuery;
use XTags\Application\Query\Tags\GetAllTagsByIdResource\GetAllTagsByIdResourceQuery;
use XTags\Application\Query\Vocabularies\GetByIdVocabulary\GetByIdVocabularyQuery;
use XTags\Application\Query\Vocabularies\GetByNameVocabulary\GetByNameVocabularyQuery;
use XTags\Domain\Service\Vocabularies\ByIdVocabulariesFinder;

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
        $vocabularyId = $request->query->get('vocabulary');

        $version_tag = $request->query->get('tagv');
        $version_resource = $request->query->get('resourcev');
        $vocabulary_version = $request->query->get('vocababularyv');

        if ($version_tag) $version_tag = (string) $version_tag;
        if ($version_resource) $version_resource = (string) $version_resource;
        if ($vocabulary_version) $vocabulary_version = (string) $vocabulary_version;

        // Get Resource
        $resource = $this->handle(
            GetByIdResourceTagQuery::create($resourceId, $version_resource)
        );

        if (is_string($vocabularyId)) {
            $vocabulary = $this->handle(
                GetByNameVocabularyQuery::create($vocabularyId, $vocabulary_version)
            );
            $vocabularyId = $vocabulary->id()->value();
        }

        $tags = $this->handle(
            GetAllTagsByIdResourceQuery::create(
                $resource->id()->value(),
                $version_tag,
                $vocabularyId,
                $language
            )
        );

        return new JsonResponse($resource, Response::HTTP_OK);
    }
}
