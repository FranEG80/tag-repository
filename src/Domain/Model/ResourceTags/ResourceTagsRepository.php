<?php
declare(strict_types=1);

namespace XTags\Domain\Model\ResourceTags;

use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;

interface ResourceTagsRepository
{
    public function find(ResourceTagId $resourceTagId): ?ResourceTags;

    public function save(ResourceTags $resourceTag): void;

    public function findAll(): ?ResourceTagsCollection;
}