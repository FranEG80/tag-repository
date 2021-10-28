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
        $tag = ($this->create)(
            $command->langId(),        
            $command->vocabularyId(),        
            $command->definitionId(),        
            $command->name(),        
            $command->version(),  
        );

        $this->dispatchEvents($tag);

        return $tag;
    }

}
