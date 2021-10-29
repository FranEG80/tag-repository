<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Tags;

use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Shared\Domain\Model\ValueObject\Version;

interface TagsRepository
{
    public function save(Tags $tag): void;

    public function find(TagId $tagId): ?Tags;

    public function findBy($criteria, $opts = null): TagsCollection;

    public function findAll(): TagsCollection;

    public function findAllByResourceId(ResourceTagId $id, Version $version = null, VocabulariesId $vocabularyId = null, TypesId $typeId = null): TagsCollection;

    public function deleteManyById(array $ids): void;

}