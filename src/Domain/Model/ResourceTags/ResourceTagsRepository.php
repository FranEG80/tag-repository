<?php
declare(strict_types=1);

namespace XTags\Domain\Model\ResourceTags;

use XTags\Domain\Model\ResourceTags\ValueObject\ExternalResourceId;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Shared\Domain\Model\ValueObject\Version;

interface ResourceTagsRepository
{
    public function find(ResourceTagId $id): ?ResourceTags;

    public function findByIdResource(ExternalResourceId $resourceId, Version $version = null): ?ResourceTags;

    public function save(ResourceTags $resourceTag): void;

    public function findAll(): ?ResourceTagsCollection;
}