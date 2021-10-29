<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Tags;

use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\TagsCollection;
use XTags\Domain\Model\Tags\TagsRepository;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Shared\Domain\Model\ValueObject\Version;

class AllTagsByResourceIdFinder
{
    private TagsRepository $tagsRepository;

    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    public function __invoke(
        ResourceTagId $resourceId,
        ?VocabulariesId $vocabulariesId,
        ?Version $version
    ): TagsCollection
    {
        return $this->tagsRepository->findAllByResourceId($resourceId, $version, $vocabulariesId);
    }
}
