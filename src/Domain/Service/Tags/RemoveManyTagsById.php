<?php

namespace XTags\Domain\Service\Tags;

use XTags\Domain\Model\Tags\TagsRepository;

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
