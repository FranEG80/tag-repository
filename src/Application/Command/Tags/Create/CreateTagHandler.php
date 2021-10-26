<?php
declare(strict_types=1);

namespace XTags\Application\Command\Tags\Create;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Tags\Tags;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Service\Tags\CreateTags;
use XTags\Shared\Traits\EventDispatchingTrait;

class CreateTagHandler
{
    use EventDispatchingTrait;

    private CreateTags $create;

    public function __contruct(
        CreateTags $create, 
        MessageBusInterface $eventBus
    )
    {
        $this->create = $create;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateTagCommand $command): Tags
    {
        $uuid = TagId::v4();

        $tag = ($this->create)(
            $uuid,
            $command->customName(),
            $command->resourceId(),
            $command->vocabularyId(),
            $command->langId(),
            $command->typeId(),
        );

        $this->dispatchEvents($tag);

        return $tag;
    }

}
