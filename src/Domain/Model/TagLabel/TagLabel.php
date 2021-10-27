<?php

namespace XTags\Domain\Model\TagLabel;

use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\TagLabel\ValueObject\DefinitionId;
use XTags\Domain\Model\TagLabel\ValueObject\LabelId;
use XTags\Domain\Model\TagLabel\ValueObject\LabelName;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Shared\Domain\Model\DomainModel;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class TagLabel extends DomainModel
{
    private const MODEL_NAME = 'tagLabel';
    const CURRENT_VERSION_TAG_LABEL = '1';

    private ?LabelId $id;
    private LabelName $name;
    private LanguagesId $langId;
    private Version $version;
    private DefinitionId $definitionId;
    private VocabulariesId $vocabularyId;
    private DateTimeInmutable $createdAt;
    private DateTimeInmutable $updatedAt;

    private function __construct(
        LabelId $id = null,
        LabelName $name, 
        LanguagesId $langId, 
        DefinitionId $definitionId,
        VocabulariesId $vocabularyId,
        Version $version = null,
        DateTimeInmutable $createdAt = null,
        DateTimeInmutable $updatedAt = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->langId = $langId;
        $this->definitionId = $definitionId;
        $this->vocabularyId = $vocabularyId;
        $this->version = $version ? $version : Version::from(self::CURRENT_VERSION_TAG_LABEL);
        $this->createdAt = $createdAt ? $createdAt : new DateTimeInmutable('now');
        $this->updatedtAt = $updatedAt ? $updatedAt : new DateTimeInmutable('now');
    }

    public static function modelName(): string
    {
        return self::MODEL_NAME;
    }

    /**
     * Used to create a non previously existent entity. May register events.
     */
    public static function create(
        TagId $tagId,
        LabelName $name, 
        LanguagesId $langId,
        DefinitionId $definitionId,
        VocabulariesId $vocabularyId
    ): self
    {
        $instance = new self(null, $name, $langId, $definitionId, $vocabularyId);
        
        //TODO record message
        // $instance->recordThat(TagLabelWasCreated::from($instance->id(), $instance->name()));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(
        LabelId $id, 
        LabelName $name, 
        LanguagesId $langId, 
        DefinitionId $definitionId,
        VocabulariesId $vocabularyId,
        Version $version,
        DateTimeInmutable $createdAt,
        DateTimeInmutable $updatedAt
    ): self
    {
        return new self($id, $name, $langId, $definitionId, $vocabularyId, $version, $createdAt, $updatedAt);
    }

    public function id(): LabelId
    {
        return $this->id;
    }

    public function name(): LabelName
    {
        return $this->name;
    }

    public function langId(): LanguagesId
    {
        return $this->langId;
    }

    public function definitionId(): DefinitionId
    {
        return $this->definitionId;
    }

    public function vocabularyId(): VocabulariesId
    {
        return $this->vocabularyId;
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
            'id' => $this->id,
            'name' => $this->name,
            'langId' => $this->langId,
            'definitionId' => $this->definitionId,
            'vocabularyId' => $this->vocabularyId,
            'version' => $this->version,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }
}