<?php
declare(strict_types=1);

namespace XTags\Domain\Model\ResourceTags;

use XTags\Domain\Model\ResourceTags\Event\ResourceTagWasCreated;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Shared\Domain\Model\DomainModel;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class ResourceTags extends DomainModel
{
    private const MODEL_NAME = 'resourceTag';
    const CURRENT_VERSION_RESOURCE_TAG = '1';

    private ResourceTagId $resource_id;
    private TagId $tag_id;
    private Version $version;
    private DateTimeInmutable $createdAt;
    private DateTimeInmutable $updatedAt;

    private function __construct(ResourceTagId $resource_id, $tag_id, $version = null, DateTimeInmutable $createdAt = null, DateTimeInmutable $updatedAt = null)
    {
        $this->resource_id = $resource_id;
        $this->tag_id = $tag_id;
        if (!$version) $this->version = Version::from((int) self::CURRENT_VERSION_RESOURCE_TAG);
        if ($createdAt) $this->createdAt = $createdAt;
        if ($updatedAt) $this->updatedAt = $updatedAt;
    }

    public static function modelName(): string
    {
        return self::MODEL_NAME;
    }

    /**
     * Used to create a non previously existent entity. May register events.
     */
    public static function create(ResourceTagId $resource_id, TagId $tag_id): self
    {
        $instance = new self($resource_id, $tag_id, Version::from((int) self::CURRENT_VERSION_RESOURCE_TAG));
        $instance->recordThat(ResourceTagWasCreated::from($instance->resourceId(), $instance->tagId()));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(ResourceTagId $resource_id, TagId $tag_id, DateTimeInmutable $createdAt, DateTimeInmutable $updatedAt): self
    {
        return new self($resource_id, $tag_id, $createdAt, $updatedAt);
    }

    public function resourceId(): ResourceTagId
    {
        return $this->resource_id;
    }

    public function tagId(): TagId
    {
        return $this->tag_id;
    }

    public function version(): Version
    {
        return $this->version;
    }

    public function createdAt(): DateTimeInmutable
    {
        return $this->createdAt;
    }


    public function updatedAt(): DateTimeInmutable
    {
        return $this->updatedAt;
    }

    public function jsonSerialize()
    {
        return [
            'resource_id' => $this->resource_id,
            'tag_id' => $this->tag_id,
            'version' => $this->version,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}