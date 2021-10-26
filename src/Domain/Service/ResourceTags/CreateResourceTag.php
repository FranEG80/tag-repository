<?php
declare(strict_types=1);

namespace XTags\Domain\Service\ResourceTags;

use XTags\Domain\Model\ResourceTags\Exception\ResourceTagsAlreadyExistException;
use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Model\ResourceTags\ResourceTagsRepository;
use XTags\Domain\Model\ResourceTags\Exception\ResourceTagsDoesNotExistException;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Infrastructure\Exceptions\Api\ResourceTagsResource;

class CreateResourceTag
{
    private ResourceTagsRepository $repository;

    public function __construct(ResourceTagsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ResourceTagId $resourceTagsId, TagId $tagId): ResourceTags
    {
        $this->assertResourceTagDoesNotExists($resourceTagsId);

        $resourceTag = ResourceTags::create($resourceTagsId, $tagId);

        $this->repository->save($resourceTag);

        return $resourceTag;
    }

    public function assertResourceTagDoesNotExists(ResourceTagId $resourceId): void
    {
        if (null !== $this->repository->find($resourceId)) {
            throw new ResourceTagsAlreadyExistException(ResourceTagsResource::create(), null);
        }
    }
}
