<?php
declare(strict_types=1);

namespace XTags\Application\Command\Tags\RemoveManyTags;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Tags\Tags;
use XTags\Domain\Service\Tags\CreateTags;
use XTags\Shared\Traits\EventDispatchingTrait;

class RemoveManyTagsTagHandler
{
    use EventDispatchingTrait;

    private CreateTags $removeMany;

    public function __contruct(
        CreateTags $removeMany, 
        MessageBusInterface $eventBus
    )
    {
        $this->removeMany = $removeMany;
        $this->eventBus = $eventBus;
    }

    public function __invoke(RemoveManyTagsCommand $command): Tags
    {
        return ($this->removeMany)();
    }

}
