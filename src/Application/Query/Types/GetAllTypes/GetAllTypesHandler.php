<?php

namespace XTags\Application\Query\Types\GetAllTypes;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Query\Types\GetAllTypes\GetAllTypesQuery;
use XTags\Domain\Model\Types\TypesCollection;
use XTags\Domain\Model\Types\TypesRepository;
use XTags\Domain\Service\Types\AllTypesFinder;

class GetAllTypesHandler
{

    private AllTypesFinder $allTypesFinder;

    public function __construct(
        AllTypesFinder $allTypesFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->allTypesFinder = $allTypesFinder;
    }

    /**
     * @return TypesCollection
     */
    public function __invoke(GetAllTypesQuery $query)
    {
        $types = [];
        $types[] = ($this->allTypesFinder)();
        return $types;
    }
}
