<?php

namespace XTags\Application\Query\TagLabel\GetAllTagLabel;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Query\TagLabel\GetAllTagLabel\GetAllTagLabelQuery;
use XTags\Domain\Model\TagLabel\TagLabelCollection;
use XTags\Domain\Model\TagLabel\TagLabelRepository;
use XTags\Domain\Service\TagLabel\AllTagLabelFinder;

class GetAllTagLabelHandler
{

    private AllTagLabelFinder $allTagLabelFinder;

    public function __construct(
        AllTagLabelFinder $allTagLabelFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->allTagLabelFinder = $allTagLabelFinder;
    }

    /**
     * @return TagLabelCollection
     */
    public function __invoke(GetAllTagLabelQuery $query)
    {
        $tagLabel = [];
        $tagLabel[] = ($this->allTagLabelFinder)();
        return $tagLabel;
    }
}
