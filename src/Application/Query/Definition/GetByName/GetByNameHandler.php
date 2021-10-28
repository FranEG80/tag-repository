<?php
declare(strict_types=1);

namespace XTags\Application\Query\Definition\GetByName;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Definition\DefinitionCollection;
use XTags\Domain\Service\Definition\ByDefinitionNameFinder;

class GetByNameHandler
{

    private ByDefinitionNameFinder $definitionByNameFinder;

    public function __construct(
        ByDefinitionNameFinder $definitionByNameFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->definitionByNameFinder = $definitionByNameFinder;
    }

    /**
     * @return DefinitionCollection
     */
    public function __invoke(GetByNameQuery $query)
    {
        return ($this->definitionByNameFinder)($query->name());
    }
}
