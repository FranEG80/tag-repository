<?php
declare(strict_types=1);

namespace XTags\Application\Command\Definition\Create;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Definition\Definition;
use XTags\Domain\Service\Definition\CreateDefinition;
use XTags\Shared\Traits\EventDispatchingTrait;

class CreateDefinitionHandler
{
    use EventDispatchingTrait;

    private CreateDefinition $create;

    public function __construct(CreateDefinition $create, MessageBusInterface $eventBus)
    {
        $this->create = $create;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateDefinitionCommand $command): Definition
    {
        $definition = ($this->create)($command->name());

        $this->dispatchEvents($definition);

        return $definition;
    }

}
