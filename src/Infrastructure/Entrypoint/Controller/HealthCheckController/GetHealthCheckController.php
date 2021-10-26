<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Entrypoint\Controller\HealthCheckController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetHealthCheckController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        $response = new JsonResponse();
        $response->setData([
            "Health check" => 'ok'
        ]);

        return $response;
    }
}
