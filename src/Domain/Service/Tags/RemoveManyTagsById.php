<?php

namespace XTags\Domain\Service\Tags;

use XTags\Domain\Model\Tags\Exception\TagsAlreadyExistException;
use XTags\Domain\Model\Tags\TagsRepository;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Infrastructure\Exceptions\Api\TagsResources;

class RemoveManyTagsById
{
    protected TagsRepository $repository;

    public function __construct(TagsRepository $repository )
    {
        $this->repository = $repository;
    }

    public function __invoke($toDelete): void
    {
        $this->repository->deleteManyById($toDelete);        
    }


}
