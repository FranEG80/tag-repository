<?php

namespace XTags\Infrastructure\Entrypoint\Controller\VocabulariesController\Get;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Query\Vocabularies\GetAllVocabularies\GetAllVocabulariesQuery;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetVocabulariesController extends AbstractController
{    
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $id = (string) $request->query->get('id', null);
        if ($id) $id = VocabulariesId::from($id);

        $output = [
            'getVocabularies' => 'ok'
        ];

        $data = $this->handle(
            GetAllVocabulariesQuery::create()
        );

        $output['data'] = $data;

        return new JsonResponse($output, Response::HTTP_OK);
    }
}
