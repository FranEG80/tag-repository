<?php
declare(strict_types=1);

namespace XTags\Domain\Model\ResourceTags;

use XTags\Domain\Model\ResourceTags\Event\ResourceTagWasCreated;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalResourceId;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalSystemId;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Shared\Domain\Model\DomainModel;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class ResourceTags extends DomainModel
{
    private const MODEL_NAME = 'resourceTag';
    const CURRENT_VERSION_RESOURCE_TAG = '1';

    const EXTERNAL_SYSTEM = 0;

    private ResourceTagId $id;
    private ExternalResourceId $resourceId;
    private Version $version;
    private ExternalSystemId $externalSystem;
    private DateTimeInmutable $createdAt;
    private DateTimeInmutable $updatedAt;

    private function __construct(
        ResourceTagId $id, 
        ExternalResourceId $resourceId, 
        Version $version = null,
        DateTimeInmutable $createdAt = null, 
        DateTimeInmutable $updatedAt = null
    )
    {
        $this->id = $id;
        $this->resourceId = $resourceId;
        $this->externalSystem = ExternalSystemId::from(self::EXTERNAL_SYSTEM);
        $this->version = ($version) ? $version : Version::from(self::CURRENT_VERSION_RESOURCE_TAG);
        $this->createdAt = ($createdAt) ? $createdAt : new DateTimeInmutable('now');
        $this->updatedAt = ($updatedAt) ? $createdAt : new DateTimeInmutable('now');
    }

    public static function modelName(): string
    {
        return self::MODEL_NAME;
    }

    /**
     * Used to create a non previously existent entity. May register events.
     */
    public static function create(ExternalResourceId $resourceId, Version $v = null): self
    {
        $version = null !== $v ? $v : Version::from(self::CURRENT_VERSION_RESOURCE_TAG);
        $instance = new self( ResourceTagId::v4(), $resourceId, $version);
        $instance->recordThat(ResourceTagWasCreated::from(
            $instance->id(), 
            $instance->resourceId(),
            $instance->externalSystem(),
            $instance->version(),
            $instance->createdAt(),
            $instance->updatedAt()
        ));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(
        ResourceTagId $id,
        ExternalResourceId $resourceId,
        Version $version,
        $createdAt, 
        $updatedAt
    ): self
    {
        return new self( $id, $resourceId, $version, $createdAt, $updatedAt);
    }

    public function resourceId(): ExternalResourceId
    {
        return $this->resourceId;
    }

    public function id(): ResourceTagId
    {
        return $this->id;
    }

    public function version(): Version
    {
        return $this->version;
    }

    public function externalSystem(): ExternalSystemId
    {
        return $this->externalSystem;
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
            'id' => $this->id,
            'external_resource_id' => $this->resourceId,
            'version' => $this->version,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}