<?php

namespace XTags\Infrastructure\Entrypoint\Controller\TypesController\Get;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Query\Types\GetAllTypes\GetAllTypesQuery;

class GetTypesController extends AbstractController
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
            GetAllTypesQuery::create()
        );
        
        foreach($data[0] as $value) $output['data'][] = $value->jsonSerialize();

        return new JsonResponse($output, Response::HTTP_OK);
    }
}
