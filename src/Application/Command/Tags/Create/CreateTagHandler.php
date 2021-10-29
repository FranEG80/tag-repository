<?php
declare(strict_types=1);

namespace XTags\Application\Command\Tags\Create;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Tags\Tags;
use XTags\Domain\Service\Tags\CreateTags;
use XTags\Shared\Traits\EventDispatchingTrait;

class CreateTagHandler
{
    use EventDispatchingTrait;

    private CreateTags $create;

    public function __construct(
        CreateTags $create, 
        MessageBusInterface $eventBus
    )
    {
        $this->create = $create;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateTagCommand $command): Tags
    {
        $tag = ($this->create)(
            $command->name(),
            $command->definition(),
            $command->resourceId(),
            $command->vocabularyId(),
            $command->typesId()
        );

        // $this->dispatchEvents($tag);

        return $tag;
    }

}
