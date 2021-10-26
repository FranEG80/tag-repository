<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Entrypoint\Controller\NotImplementedController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class NotImplementedController extends AbstractController
{
    public function __invoke(): Response
    {
        return new Response('', Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
