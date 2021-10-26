<?php
declare(strict_types=1);

namespace XTags\Application\Command\ResourceTags\Create;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Service\ResourceTags\CreateResourceTag;
use XTags\Shared\Traits\EventDispatchingTrait;

class CreateResourceTagHandler
{
    use EventDispatchingTrait;

    private CreateResourceTagCommand $create;

    public function __construct(CreateResourceTag $create, MessageBusInterface $eventBus)
    {
        $this->create = $create;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateResourceTagCommand $command): ResourceTags
    {
        $resourceTag = ($this->create)(
            $command->resourceId(),
            TagId::v4()
        );

        $this->dispatchEvents($resourceTag);

        return $resourceTag;
    }

}
