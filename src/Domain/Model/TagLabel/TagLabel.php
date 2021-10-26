<?php

namespace XTags\Domain\Model\TagLabel;

use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelId;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelName;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Shared\Domain\Model\DomainModel;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class TagLabel extends DomainModel
{
    private const MODEL_NAME = 'tagLabel';
    const CURRENT_VERSION_TAG_LABEL = 1;

    private TagLabelId $id;
    private TagId $tagId;
    private TagLabelName $name;
    private LanguagesId $langId;
    private Version $version;

    private function __construct( ?TagLabelId $id, TagId $tagId, TagLabelName $name, LanguagesId $langId, Version $version)
    {
        $this->id = $id;
        $this->tagId = $tagId;
        $this->name = $name;
        $this->langId = $langId;
        $this->version = $version;
    }

    public static function modelName(): string
    {
        return self::MODEL_NAME;
    }

    /**
     * Used to create a non previously existent entity. May register events.
     */
    public static function create(TagId $tagId, TagLabelName $name, LanguagesId $langId): self
    {
        $instance = new self(null, $tagId, $name, $langId, Version::from(self::CURRENT_VERSION_TAG_LABEL));
        
        //TODO record message
        // $instance->recordThat(TagLabelWasCreated::from($instance->id(), $instance->name()));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(TagLabelId $id, TagId $tagId, TagLabelName $name, LanguagesId $langId, Version $version): self
    {
        return new self( $id, $tagId, $name, $langId, $version);
    }

    public function id(): TagLabelId
    {
        return $this->id;
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function name(): TagLabelName
    {
        return $this->name;
    }

    public function langId(): LanguagesId
    {
        return $this->langId;
    }

    public function version(): Version
    {
        return $this->version;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'tagId' => $this->tagId,
            'name' => $this->name,
            'langId' => $this->langId,
            'version' => $this->version
        ];
    }
}