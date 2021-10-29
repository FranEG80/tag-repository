<?php
declare(strict_types=1);

namespace XTags\Application\Query\Tags\GetAllTagsByIdResource;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Tags\TagsCollection;
use XTags\Domain\Service\Tags\AllTagsByResourceIdFinder;
use XTags\Domain\Service\Tags\AllTagsFinder;

class GetAllTagsByIdResourceHandler
{
    private AllTagsByResourceIdFinder $allTagByIdResourceFinder;

    public function __construct(
        AllTagsByResourceIdFinder $allTagByIdResourceFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->allTagByIdResourceFinder = $allTagByIdResourceFinder;
    }

    public function __invoke(
        GetAllTagsByIdResourceQuery $query
    ): TagsCollection
    {
        return ($this->allTagByIdResourceFinder)(
            $query->resourceId(), 
            $query->vocabularyId(), 
            $query->version()
        );
    }
}
