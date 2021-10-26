<?php
declare(strict_types=1);

namespace XTags\Domain\Service\ResourceTags;

use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Model\ResourceTags\ResourceTagsRepository;
use XTags\Domain\Model\ResourceTags\Exception\ResourceTagsDoesNotExistException;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Infrastructure\Exceptions\Api\ResourceTagsResource;

class ByIdResourceTagsFinder
{
    private ResourceTagsRepository $resourceTagsRepository;

    public function __construct(ResourceTagsRepository $resourceTagsRepository)
    {
        $this->resourceTagsRepository = $resourceTagsRepository;
    }

    public function __invoke(ResourceTagId $resourceTagsId): ResourceTags
    {
        $resourceTags = $this->resourceTagsRepository->find($resourceTagsId);

        if (null === $resourceTags) {
            throw new ResourceTagsDoesNotExistException(ResourceTagsResource::create());
        }

        return $resourceTags;
    }
}
