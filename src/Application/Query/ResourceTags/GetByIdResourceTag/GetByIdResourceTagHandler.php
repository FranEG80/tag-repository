<?php
declare(strict_types=1);

namespace XTags\Application\Query\ResourceTags\GetByIdResourceTag;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\ResourceTags\ResourceTagsCollection;
use XTags\Domain\Model\ResourceTags\ResourceTagsRepository;
use XTags\Domain\Service\ResourceTags\AllResourceTagsFinder;

class GetByIdResourceTagHandler
{

    private AllResourceTagsFinder $allResourceTagsFinder;

    public function __construct(
        AllResourceTagsFinder $allResourceTagsFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->allResourceTagsFinder = $allResourceTagsFinder;
    }

    /**
     * @return ResourceTagsCollection
     */
    public function __invoke(GetByIdResourceTagQuery $query)
    {
        $tagLabel = [];
        $tagLabel[] = ($this->allResourceTagsFinder)();
        return $tagLabel;
    }
}
