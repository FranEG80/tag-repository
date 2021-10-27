<?php
declare(strict_types=1);

namespace XTags\Application\Query\ResourceTags\GetByIdResourceTag;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\ResourceTags\ResourceTagsCollection;
use XTags\Domain\Service\Resource\ByIdResourceFinder;
use XTags\Domain\Service\ResourceTags\AllResourceTagsFinder;
use XTags\Shared\Domain\Model\ValueObject\Version;

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

    /**
     * @return ResourceTagsCollection
     */
    public function __invoke(GetByIdResourceTagQuery $query)
    {
        $tagLabel = [];
        $tagLabel[] = ($this->getResourceById)($query->resourceId(), $query->version());
        return $tagLabel;
    }
}
