<?php

namespace XTags\Domain\Model\TagLabel;

use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
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
    private ?LabelName $name;
    private LanguagesId $langId;
    private TagId $tagId;

    private function __construct(
        LabelId $id = null,
        LabelName $name = null, 
        LanguagesId $langId, 
        TagId $tagId
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->langId = $langId;
        $this->tagId = $tagId;
    }

    public static function modelName(): string
    {
        return self::MODEL_NAME;
    }

    /**
     * Used to create a non previously existent entity. May register events.
     */
    public static function create(
        LabelName $name = null, 
        LanguagesId $langId,
        TagId $tagId
    ): self
    {
        $instance = new self(null, $name, $langId, $tagId);
        
        //TODO record message
        // $instance->recordThat(TagLabelWasCreated::from($instance->id(), $instance->name()));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(
        LabelId $id = null,
        LabelName $name = null, 
        LanguagesId $langId, 
        TagId $tagId
    ): self
    {
        return new self($id, $name, $langId, $tagId);
    }

    public function id(): ?LabelId
    {
        return $this->id;
    }

    public function name(): ?LabelName
    {
        return $this->name;
    }

    public function langId(): LanguagesId
    {
        return $this->langId;
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'langId' => $this->langId,
            'tagId' => $this->tagId
        ];
    }
}