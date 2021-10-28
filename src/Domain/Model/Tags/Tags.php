<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Tags;

use XTags\Domain\Model\Definition\ValueObject\DefinitionId;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\ValueObject\TagName;
use XTags\Domain\Model\Tags\Event\TagWasCreated;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Shared\Domain\Model\DomainModel;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class Tags extends DomainModel
{
    private const MODEL_NAME = 'tags';
    const CURRENT_VERSION_TAG = '1';

    private TagId $id;
    private VocabulariesId $vocabularyId;
    private TypesId $typeId;
    private DefinitionId $defintionId;
    private ResourceTagId $resourceId;
    private TagName $customName;
    private DateTimeInmutable $createdAt;
    private DateTimeInmutable $updatedAt;
    private Version $version;

    private function __construct(
        TagId $id,
        TagName $customName,
        DefinitionId $definitionId,
        ResourceTagId $resourceId,
        VocabulariesId $vocabularyId,
        TypesId $typeId,
        DateTimeInmutable $createdAt,
        DateTimeInmutable $updatedAt,
        Version $version
    )
    {
        $this->id = $id;
        $this->customName = $customName;
        $this->defintionId = $definitionId;
        $this->resourceId = $resourceId;
        $this->vocabularyId = $vocabularyId;
        $this->typeId = $typeId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->version = $version;
    }

    public static function modelName(): string
    {
        return self::MODEL_NAME;
    }

    /**
     * Used to create a non previously existent entity. May register events.
     */
    public static function create(
        TagId $id,
        TagName $customName,
        DefinitionId $definitionId,
        ResourceTagId $resourceId,
        VocabulariesId $vocabularyId,
        TypesId $typeId
    ): self
    {
        $dateNow = new DateTimeInmutable();
        $instance = new self(
            $id, 
            $customName,
            $definitionId,
            $resourceId, 
            $vocabularyId, 
            $typeId, 
            $dateNow, 
            $dateNow, 
            Version::from(self::CURRENT_VERSION_TAG)
        );

        $instance->recordThat(TagWasCreated::from(
            $instance->id(), 
            $instance->customName(),
            $instance->definitionId(),
            $instance->resourceId(),
            $instance->vocabularyId(),
            $instance->typeId(),
            $instance->createdAt(),
            $instance->updatedAt(),
            $instance->version()
        ));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(
        TagId $id,
        TagName $customName,
        DefinitionId $definitionId,
        ResourceTagId $resourceId,
        VocabulariesId $vocabularyId,
        TypesId $typeId,
        DateTimeInmutable $createdAt,
        DateTimeInmutable $updatedAt,
        Version $version
    ): self
    {
        return new self($id, $customName, $definitionId, $resourceId, $vocabularyId, $typeId, $createdAt, $updatedAt, $version);
    }

    public function id(): TagId
    {
        return $this->id;
    }

    public function customName(): TagName
    {
        return $this->customName;
    }
    
    public function resourceId(): ResourceTagId
    {
        return $this->resourceId;
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

    public function version(): Version
    {
        return $this->version;
    }

    public function definitionId()
    {
        return $this->defintionId;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'tag_mame' => $this->customName,
            'definition_id' => $this->defintionId,
            'resource_tag_id' => $this->resourceId,
            'vocabularies_id' => $this->vocabularyId,
            'types_id' => $this->typeId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'version' => $this->version
        ];
    }
}