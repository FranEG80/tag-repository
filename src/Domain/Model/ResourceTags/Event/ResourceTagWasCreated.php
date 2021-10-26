<?php
declare(strict_types=1);

namespace XTags\Domain\Model\ResourceTags\Event;

use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Infrastructure\Message\Generator\ResourceTags\ResourceTagsEvent;
use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;

final class ResourceTagWasCreated extends DomainEvent
{
    private const NAME = 'was_created';
    private const VERSION = '1';

    private string $name;

    public static function from(ResourceTagId $resource_id, TagId $tag_id)
    {
        return self::fromPayload(
            Uuid::v4(),
            $resource_id,
            new DateTimeValueObject(),
            self::buildPayload($tag_id),
        );
    }

    public function name(): string
    {
        return $this->name;
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

        $this->name = $payload['name'];
    }

    private static function buildPayload(TagId $tag_id): array
    {
        return \json_decode(
            \json_encode([
                'name' => $tag_id->__toString()
            ]),
            true,
        );
    }
}
