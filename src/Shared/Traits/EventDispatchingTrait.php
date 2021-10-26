<?php
declare(strict_types=1);

namespace XTags\Shared\Traits;

use XTags\Shared\Domain\Model\DomainModel;
use Symfony\Component\Messenger\MessageBusInterface;

trait EventDispatchingTrait
{
    private MessageBusInterface $eventBus;

    private function dispatchEvents(DomainModel $model): void
    {
        $events = $model->events();

        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
