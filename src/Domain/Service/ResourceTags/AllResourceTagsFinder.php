<?php
declare(strict_types=1);

namespace XTags\Domain\Service\ResourceTags;

use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Model\ResourceTags\ResourceTagsCollection;
use XTags\Domain\Model\ResourceTags\ResourceTagsRepository;
use XTags\Domain\Model\ResourceTags\Exception\ResourceTagsDoesNotExistException;
use XTags\Infrastructure\Exceptions\Api\ResourceTagsResource;

class AllResourceTagsFinder
{
    private ResourceTagsRepository $resourceTagsRepository;

    public function __construct(ResourceTagsRepository $resourceTagsRepository)
    {
        $this->resourceTagsRepository = $resourceTagsRepository;
    }

    public function __invoke(): ResourceTagsCollection
    {
        $resourceTags = $this->resourceTagsRepository->findAll();

        if (null === $resourceTags) {
            throw new ResourceTagsDoesNotExistException(ResourceTagsResource::create());
        }

        return $resourceTags;
    }
}
