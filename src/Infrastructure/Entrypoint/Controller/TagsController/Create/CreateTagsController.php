<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Entrypoint\Controller\TagsController\Create;

use Assert\Assertion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Command\ResourceTags\Create\CreateResourceTagCommand;
use XTags\Application\Command\TagLabel\Create\CreateTagLabelCommand;
use XTags\Application\Command\TagLabel\Create\CreateTagLabelHandler;
use XTags\Application\Command\Tags\Create\CreateTagCommand;
use XTags\Domain\Model\Tags\ValueObject\TagId;

class CreateTagsController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;   
    }

    public function __invoke(Request $request): JsonResponse
    {
        $output = new JsonResponse();

        Assertion::isJsonString($request->getContent());

        $body = new ParameterBag(
            \json_decode(
                $request->getContent(),
                true,
            ),
        );

        $uuid = TagId::v4();


        $tag = $this->handle(
            CreateTagCommand::create(
                $body->get('customName'),
                $body->get('resourceid'),
                $body->get('vocabularyId'),
                $body->get('langId'),
                $body->get('typeId'),
                $body->get('definition_id')
            )
        );

        $tag_label = $this->handle(
            CreateTagLabelCommand::create(

            )
        );

        $resourceTag = $this->handle(
            CreateResourceTagCommand::create(
            )
        );

        $output->setData($tag);

        return $output;
    }
}
