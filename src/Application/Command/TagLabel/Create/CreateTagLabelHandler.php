<?php
declare(strict_types=1);

namespace XTags\Application\Command\TagLabel\Create;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\TagLabel\TagLabel;
use XTags\Domain\Service\TagLabel\CreateTagLabel;
use XTags\Shared\Traits\EventDispatchingTrait;

class CreateTagLabelHandler
{
    use EventDispatchingTrait;

    private CreateTagLabel $create;

    public function __contruct(
        CreateTagLabel $create, 
        MessageBusInterface $eventBus
    )
    {
        $this->create = $create;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateTagLabelCommand $command): TagLabel
    {
        $tagLabel = ($this->create)(
            $command->langId(),        
            $command->vocabularyId(),        
            $command->definitionId(),        
            $command->name(),        
            $command->version(),  
        );

        $this->dispatchEvents($tagLabel);

        return $tagLabel;
    }

}
