<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Tags;

use XTags\Domain\Model\Tags\ValueObject\TagId;

interface TagsRepository
{
    public function save(Tags $tag): void;

    public function find(TagId $tagId): ?Tags;

    public function findAll(): TagsCollection;
}