<?php

namespace XTags\Domain\Model\Languages;

use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\Languages\ValueObject\LanguagesName;

final class Languages
{
    private const MODEL_NAME = 'languages';

    private LanguagesId $id;
    private LanguagesName $name;

    private function __construct( LanguagesId $id, LanguagesName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function modelName(): string
    {
        return self::MODEL_NAME;
    }

    /**
     * Used to create a non previously existent entity. May register events.
     */
    public static function create( LanguagesId $id, LanguagesName $name ): self
    {
        $instance = new self($id, $name);
        
        //TODO record message
        // $instance->recordThat(LanguagesWasCreated::from($instance->id(), $instance->name()));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(LanguagesId $id, LanguagesName $name ): self
    {
        return new self($id, $name);
    }

    public function id(): LanguagesId
    {
        return $this->id;
    }

    public function name(): LanguagesName
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}