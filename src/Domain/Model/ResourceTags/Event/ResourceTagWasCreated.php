<?php
declare(strict_types=1);

namespace XTags\Domain\Model\ResourceTags\Event;

use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Infrastructure\Message\Generator\ResourceTags\ResourceTagsEvent;
use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalResourceId;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalSystemId;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class ResourceTagWasCreated extends DomainEvent
{
    private const NAME = 'was_created';
    private const VERSION = '1';

    private ResourceTagId $id;
    private ExternalResourceId $resourceId;
    private Version $version;

    public static function from(
        ResourceTagId $id, 
        ExternalResourceId $resourceId,
        ExternalSystemId $externalSystemId,
        Version $version,
        DateTimeInmutable $createdAt,
        DateTimeInmutable $updatedAt
    )
    {
        return self::fromPayload(
            Uuid::v4(),
            $resourceId,
            new DateTimeValueObject(),
            self::buildPayload( 
                $id, 
                $resourceId, 
                $externalSystemId,
                $version, 
                $createdAt, 
                $updatedAt
            ),
        );
    }

    public function id(): ResourceTagId
    {
        return $this->id;
    }

    public function resourceId(): ExternalResourceId
    {
        return $this->resourceId;
    }

    public function version(): Version
    {
        return $this->version;
    }

    public static function messageName(): string
    {
        return ResourceTagsEvent::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
        $payload = $this->messagePayload();

        $this->id = ResourceTagId::from($payload['id']);
        $this->resourceId = ExternalResourceId::from($payload['external_resource_id']);
        $this->externalSystemId = ExternalSystemId::from($payload['external_system_id']);
        $this->createdAt = DateTimeInmutable::from($payload['created_at']);
        $this->updatedAt = DateTimeInmutable::from($payload['updated_at']);
        $this->version = $payload['version'] ? Version::from($payload['version']) : null;
    }

    private static function buildPayload(
        ResourceTagId $id, 
        ExternalResourceId $resourceId,
        ExternalSystemId $externalSystemId,
        Version $version,
        DateTimeInmutable $createdAt,
        DateTimeInmutable $updatedAt
    ): array
    {
        return \json_decode(
            \json_encode([
                'id' => $id,
                'external_resource_id' => $resourceId,
                'external_system_id' => $externalSystemId,
                'version' => $version,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt
            ]),
            true,
        );
    }
}
