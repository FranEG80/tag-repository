<?php
declare(strict_types=1);

namespace XTags\Shared\Domain\Model;

use PcComponentes\Ddd\Domain\Model\DomainEvent;

abstract class DomainModel implements \JsonSerializable
{
    protected array $events;

    protected function __construct()
    {
        $this->events = [];
    }

    abstract public static function modelName(): string;

    final public function events(): array
    {
        return $this->events;
    }

    final protected function recordThat(DomainEvent $event): void
    {
        $this->events[] = $event;
    }
}
