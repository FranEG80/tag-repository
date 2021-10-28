<?php

namespace XTags\Domain\Model\Definition;

use XTags\Domain\Model\Definition\ValueObject\DefinitionId;
use XTags\Domain\Model\Definition\ValueObject\DefinitionName;
use XTags\Shared\Domain\Model\DomainModel;

final class Definition extends DomainModel
{
    private const MODEL_NAME = 'definition';

    private ?DefinitionId $id;
    private DefinitionName $name;

    private function __construct( DefinitionId $id = null, DefinitionName $name)
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
    public static function create( DefinitionName $name ): self
    {
        $instance = new self(null, $name);
        
        //TODO record message
        // $instance->recordThat(DefinitionWasCreated::from($instance->id(), $instance->name()));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(DefinitionId $id, DefinitionName $name ): self
    {
        return new self($id, $name);
    }

    public function id(): ?DefinitionId
    {
        return $this->id;
    }

    public function name(): DefinitionName
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