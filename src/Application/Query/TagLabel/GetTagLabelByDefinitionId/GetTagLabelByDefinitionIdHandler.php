<?php

namespace XTags\Application\Query\TagLabel\GetTagLabelByDefinitionId;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Definition\DefinitionCollection;
use XTags\Domain\Service\TagLabel\GetTagLabelByDefinitionId;

class GetTagLabelByDefinitionIdHandler

{

    private GetTagLabelByDefinitionId $finder;

    public function __construct(
        GetTagLabelByDefinitionId $finder,
        MessageBusInterface $eventBus
    )
    {
        $this->finder = $finder;
    }

    /**
     * @return DefinitionCollection
     */
    public function __invoke(GetTagLabelByDefinitionId $query)
    {
        return ($this->finder)();
    }
}
