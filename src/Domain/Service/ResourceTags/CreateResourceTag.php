<?php
declare(strict_types=1);

namespace XTags\Domain\Service\ResourceTags;

use XTags\Domain\Model\ResourceTags\Exception\ResourceTagsAlreadyExistException;
use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Model\ResourceTags\ResourceTagsRepository;
use XTags\Domain\Model\ResourceTags\Exception\ResourceTagsDoesNotExistException;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalResourceId;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Infrastructure\Exceptions\Api\ResourceTagsResource;
use XTags\Shared\Domain\Model\ValueObject\Version;

class CreateResourceTag
{
    private ResourceTagsRepository $repository;

    public function __construct(ResourceTagsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ExternalResourceId $resourceTagsId, Version $version = null): ResourceTags
    {
        $this->assertResourceTagDoesNotExists($resourceTagsId);

        $resourceTag = ResourceTags::create($resourceTagsId, $version);

        $this->repository->save($resourceTag);

        return $resourceTag;
    }

    public function assertResourceTagDoesNotExists(ExternalResourceId $resourceId): void
    {
        if (null !== $this->repository->findByIdResource($resourceId)) {
            throw new ResourceTagsAlreadyExistException(ResourceTagsResource::create(), null);
        }
    }
}
