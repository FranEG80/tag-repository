<?php

namespace XTags\Infrastructure\Entrypoint\Controller\TagLabelController\Get;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Query\TagLabel\GetAllTagLabel\GetAllTagLabelQuery;

class GetTagLabelController extends AbstractController
{    
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $output = ['data' => []];

        $data = $this->handle(
            GetAllTagLabelQuery::create()
        );
        
        foreach($data[0] as $value) $output['data'][] = $value->jsonSerialize();

        return new JsonResponse($output, Response::HTTP_OK);
    }
}
