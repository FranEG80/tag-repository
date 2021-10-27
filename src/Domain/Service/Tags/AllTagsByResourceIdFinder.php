<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Tags;

use XTags\Domain\Model\Tags\Exception\TagsDoesNotExistException;
use XTags\Domain\Model\Tags\TagsCollection;
use XTags\Domain\Model\Tags\TagsRepository;
use XTags\Infrastructure\Exceptions\Api\TagsResources;

class AllTagsByResourceIdFinder
{
    private TagsRepository $tagsRepository;

    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    public function __invoke(): TagsCollection
    {
        $tags = TagsCollection::from([]); //$this->tagsRepository->find();

        if (null === $tags) {
            throw new TagsDoesNotExistException(TagsResources::create());
        }

        return $tags;
    }
}
