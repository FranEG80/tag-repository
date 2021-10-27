<?php
declare(strict_types=1);

namespace XTags\Domain\Model\ResourceTags\Event;

use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Infrastructure\Message\Generator\ResourceTags\ResourceTagsEvent;
use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalResourceId;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class ResourceTagWasCreated extends DomainEvent
{
    private const NAME = 'was_created';
    private const VERSION = '1';

    private ResourceTagId $id;
    private ExternalResourceId $resourceId;
    private Version $version;

    public static function from(ResourceTagId $id, ExternalResourceId $resourceId, Version $version)
    {
        return self::fromPayload(
            Uuid::v4(),
            $resourceId,
            new DateTimeValueObject(),
            self::buildPayload($id, $resourceId),
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

        $this->id = $payload['id'];
        $this->resourceId = $payload['resourceId'];
        $this->version = $payload['version'];
    }

    private static function buildPayload(ResourceTagId $id, ExternalResourceId $resourceId): array
    {
        return \json_decode(
            \json_encode([
                'id' => $id->value(),
                'external_resource_id' => $resourceId
            ]),
            true,
        );
    }
}
