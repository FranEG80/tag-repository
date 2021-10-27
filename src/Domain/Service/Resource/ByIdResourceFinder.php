<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Resource;

use XTags\Domain\Model\ResourceTags\Exception\ResourceTagsDoesNotExistException;
use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Model\ResourceTags\ResourceTagsRepository;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalResourceId;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\TagsRepository;
use XTags\Infrastructure\Exceptions\Api\ResourceTagsResource;
use XTags\Shared\Domain\Model\ValueObject\Version;

class ByIdResourceFinder
{
    protected ResourceTagsRepository $resourceRepository;

    public function __construct(
        ResourceTagsRepository $resourceRepository
    )
    {
        $this->resourceRepository = $resourceRepository;
    }

    public function __invoke( ExternalResourceId $resourceId, Version $version = null): ResourceTags
    {
        $resource = $this->resourceRepository->findByIdResource($resourceId, $version);

        if (null === $resource) {
            throw new ResourceTagsDoesNotExistException(ResourceTagsResource::create());
        }

        return $resource;

    }
}
