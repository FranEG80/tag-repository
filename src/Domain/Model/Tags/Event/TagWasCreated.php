<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Tags\Event;

use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Infrastructure\Message\Generator\Tags\TagsEvent;
use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use XTags\Domain\Model\Tags\ValueObject\TagName;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class TagWasCreated extends DomainEvent
{
    private const NAME = 'was_created';
    private const VERSION = '1';

    private $id;    
    private $customName;
    private $resourceId;
    private $vocabularyId;
    private $typeId;
    private $createdAt;
    private $updatedAt;
    private $version;

    public static function from(
        TagId $id,
        TagName $customName,
        ResourceTagId $resourceId,
        VocabulariesId $vocabularyId,
        TypesId $typeId,
        DateTimeInmutable $createdAt,
        DateTimeInmutable $updatedAt,
        Version $version
    )
    {
        return self::fromPayload(
            Uuid::v4(),
            $id,
            new DateTimeValueObject(),
            self::buildPayload( $id, $customName, $resourceId, $vocabularyId, $typeId, $createdAt, $updatedAt, $version),
        );
    }

    public function id(): TagId
    {
        return $this->id;
    }

    public function resourceId(): ResourceTagId
    {
        return $this->resourceId;
    }

    public function customName(): TagName
    {
        return $this->customName;
    }

    public function vocabularyId(): VocabulariesId
    {
        return $this->vocabularyId;
    }

    public function typeId(): TypesId
    {
        return $this->typeId;
    }

    public function createdAt(): DateTimeInmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeInmutable
    {
        return $this->updatedAt;
    }

    public function version(): DateTimeInmutable
    {
        return $this->version;
    }

    public static function messageName(): string
    {
        return TagsEvent::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
        $payload = $this->messagePayload();

        $this->name = $payload['name'];
        $this->id = $payload['id']; 
        $this->customName = $payload['customName'];
        $this->resourceId = $payload['resourceId']; 
        $this->vocabularyId = $payload['vocabularyId']; 
        $this->typeId = $payload['typeId']; 
        $this->createdAt = $payload['createdAt']; 
        $this->updatedAt = $payload['updatedAt']; 
        $this->version = $payload['version'];
    }

    private static function buildPayload(
        TagId $id,
        TagName $customName,
        ResourceTagId $resourceId,
        VocabulariesId $vocabularyId,
        TypesId $typeId,
        DateTimeInmutable $createdAt,
        DateTimeInmutable $updatedAt,
        Version $version
    ): array
    {
        return \json_decode(
            \json_encode([
                'id' => $id, 
                'customName' => $customName,
                'resource_id' => $resourceId, 
                'vocabulary_id' => $vocabularyId, 
                'type_id' => $typeId, 
                'created_at' => $createdAt, 
                'updated_at' => $updatedAt, 
                'version' => $version
            ]),
            true,
        );
    }
}
