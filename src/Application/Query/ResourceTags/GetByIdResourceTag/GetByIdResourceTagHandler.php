<?php
declare(strict_types=1);

namespace XTags\Application\Query\ResourceTags\GetByIdResourceTag;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Service\Resource\ByIdResourceFinder;

class GetByIdResourceTagHandler
{

    private ByIdResourceFinder $allResourceTagsFinder;

    public function __construct(
        ByIdResourceFinder $getResourceById,
        MessageBusInterface $eventBus
    )
    {
        $this->getResourceById = $getResourceById;
    }

    public function __invoke(GetByIdResourceTagQuery $query): ?ResourceTags
    {
        return ($this->getResourceById)($query->resourceId(), $query->version());
    }
}
