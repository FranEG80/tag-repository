<?php

namespace XTags\Infrastructure\Entrypoint\Controller\ResourceTagsController\Save;

use Assert\Assertion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Command\ResourceTags\Create\CreateResourceTagCommand;
use XTags\Application\Command\TagLabel\Create\CreateTagLabelCommand;
use XTags\Application\Command\Tags\Create\CreateTagCommand;
use XTags\Application\Command\Tags\RemoveManyTags\RemoveManyTagsCommand;
use XTags\Application\Query\Languages\GetAllLanguages\GetAllLanguagesQuery;
use XTags\Application\Query\ResourceTags\GetByIdResourceTag\GetByIdResourceTagQuery;
use XTags\Application\Query\Tags\GetAllTagsByIdResource\GetAllTagsByIdResourceQuery;
use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\TagLabel\TagLabel;
use XTags\Domain\Model\Tags\Tags;

class SaveResourceTagsController extends AbstractController
{
    use HandleTrait;

    private const PARAMETERS_RESOURCE_REQUIRED = ['resourceId', 'vocabularyId'];
    private const PARAMETERS_TAG_REQUIRED = ['langId', 'definitionId', 'typeId'];

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;   
    }

    public function __invoke(Request $request): JsonResponse
    {
        $output = [];

        Assertion::isJsonString($request->getContent());

        $body = new ParameterBag(\json_decode($request->getContent(),true));
        $tags = $body->get('tags');

        if (!$this->checkParametersRequired($body->all(), self::PARAMETERS_RESOURCE_REQUIRED)) {
            return new JsonResponse([
                "error" => 'Resource Paramaters required'
            ], Response::HTTP_NOT_ACCEPTABLE);
        };

        $resourceVersion = $body->has('version') ? $body->get('version') : null;
        $resource = $this->getResource($body->get('resourceId'), $resourceVersion);

        // get all tags of resource
        $resourceTags = $this->handle(GetAllTagsByIdResourceQuery::create($resource->id()->value(), null, $body->get('vocabularyId')));
        // $resourceTags = $resourceTags->jsonSerialize();

        // get all ids labels each tags

        $languages = $this->handle(GetAllLanguagesQuery::create())->jsonSerialize();
        
        // check old tags && old labels
        $news = [];
        $olds = [];
        $idTagsNews = [];
        foreach ($tags as $tag) {
            if (!$this->checkParametersRequired($tag, self::PARAMETERS_TAG_REQUIRED)) {
                $error = [
                    'error' => 'Tag Parameters required',
                    'data' => $tag
                ];
                $output[] = $error;
            };

            if (!$resourceTags->hasTag(($tag['definitionId']))) $news[] = $tag;
            $idTagsNews[] = $tag['definitionId'];
        }

        $resourceTags = $resourceTags->jsonSerialize();
        foreach ($resourceTags as $resourceTag) {
            if (!array_key_exists($resourceTag->definition()->value(), $idTagsNews)) $olds[] = $resourceTag->id();
        }
        
        // update tags
        foreach ($news as $new) {
            if (!array_key_exists('name', $new)) $new['name'] = null;
            if (!array_key_exists('taglabelv', $new)) $new['taglabelv'] = TagLabel::CURRENT_VERSION_TAG_LABEL;
            
            if (!array_key_exists('tagv', $new)) $new['tagv'] = Tags::CURRENT_VERSION_TAG;
            $definitionId = (array_key_exists('definitionId', $new)) ? $new['definitionId'] : null;
            $this->handle(CreateTagCommand::create(
                $definitionId, 
                $resource->id()->value(),
                $body->get('vocabularyId'), 
                $new['definitionId'], 
                $new['name'], 
                $new['tagv'],
                $new['typeId']
            ));
        }

        // Remove olds
        $this->handle(RemoveManyTagsCommand::create($olds));

        return new JsonResponse(null, Response::HTTP_OK);
    }

    private function getResource(string $resourceId, $version): ?ResourceTags
    {
        $resource = $this->handle(GetByIdResourceTagQuery::create($resourceId, $version));

        if (null === $resource) $resource = $this->handle(CreateResourceTagCommand::create($resourceId, $version));
        
        return $resource;
    }

    private function checkParametersRequired($body, $params){
        foreach ($params as $param) {
            if (!array_key_exists($param, $body)){
                 return false;
            }
        }
        return true;
    }

}
