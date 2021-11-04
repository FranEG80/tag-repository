<?php

namespace XTags\Infrastructure\Entrypoint\Controller\VocabulariesController\GetInfoByDefinition;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class GetInfoByDefinitionController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $output = new JsonResponse();

        $id = $request->get('id');
        $vocabularyID = $request->get('vocabulary');

        if (null == $id || null == $vocabularyID) {
            return new JsonResponse([
                "error" => 'Paramaters required'
            ], JsonResponse::HTTP_NOT_ACCEPTABLE);
        }

        return $output;        
    }
}
