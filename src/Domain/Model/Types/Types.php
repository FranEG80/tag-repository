<?php

namespace XTags\Domain\Model\Types;

use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Types\ValueObject\TypesName;

final class Types
{
    private const MODEL_NAME = 'types';

    private TypesId $id;
    private TypesName $name;

    private function __construct( TypesId $id, TypesName $name)
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
    public static function create( TypesId $id, TypesName $name ): self
    {
        $instance = new self($id, $name);
        
        //TODO record message
        // $instance->recordThat(TypesWasCreated::from($instance->id(), $instance->name()));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(TypesId $id, TypesName $name ): self
    {
        return new self($id, $name);
    }

    public function id(): TypesId
    {
        return $this->id;
    }

    public function name(): TypesName
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