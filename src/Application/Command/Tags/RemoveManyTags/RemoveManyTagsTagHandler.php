<?php
declare(strict_types=1);

namespace XTags\Application\Command\Tags\RemoveManyTags;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Service\Tags\RemoveManyTagsById;
use XTags\Shared\Traits\EventDispatchingTrait;

class RemoveManyTagsTagHandler
{
    use EventDispatchingTrait;

    private RemoveManyTagsById $removeMany;

    public function __construct(
        RemoveManyTagsById $removeMany, 
        MessageBusInterface $eventBus
    )
    {
        $this->removeMany = $removeMany;
        $this->eventBus = $eventBus;
    }

    public function __invoke(RemoveManyTagsCommand $command): void
    { 
        $tags = $command->tags();
        if (count($tags) > 0 )  ($this->removeMany)($tags);
    }

}
