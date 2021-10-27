<?php
declare(strict_types=1);

namespace XTags\Application\Query\Tags\GetAllTagsByIdResource;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Service\Tags\AllTagsFinder;

class GetAllTagsByIdResourceHandler
{
//     private AllTagsFinder $allResourceTagsFinder;

//     public function __construct(
//         ByIdResourceFinder $getResourceById,
//         MessageBusInterface $eventBus
//     )
//     {
//         $this->getResourceById = $getResourceById;
//     }

//     /**
//      * @return ResourceTagsCollection
//      */
    public function __invoke(
        // GetByIdResourceTagQuery $query,
        MessageBusInterface $eventBus
    )
    {
//         $tagLabel = [];
//         $tagLabel[] = ($this->getResourceById)($query->resourceId(), $query->version());
//         return $tagLabel;
    }
}
