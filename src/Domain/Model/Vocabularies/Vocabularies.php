<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Vocabularies;

use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesName;
use XTags\Shared\Domain\Model\DomainModel;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Url;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class Vocabularies extends DomainModel
{
    private const MODEL_NAME = 'vocabularies';
    const CURRENT_VERSION = '1';

    private VocabulariesId $id;
    private VocabulariesName $name;
    private Url $url_vocabulary;
    private Url $url_definitions;
    private Url $url_search;
    private DateTimeInmutable $created_at;
    private DateTimeInmutable $update_at;
    private version $version;

    private function __construct(
        VocabulariesId $id,
        VocabulariesName $name, 
        Url $url_vocabulary, 
        Url $url_definitions, 
        Url $url_search, 
        DateTimeInmutable $created_at, 
        DateTimeInmutable $update_at, 
        Version $version
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->url_vocabulary = $url_vocabulary;
        $this->url_definitions = $url_definitions;
        $this->url_search = $url_search;
        $this->created_at = $created_at;
        $this->update_at = $update_at;
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
        VocabulariesId $id,
        VocabulariesName $name, 
        Url $url_vocabulary, 
        Url $url_definitions, 
        Url $url_search, 
        DateTimeInmutable $created_at, 
        DateTimeInmutable $update_at, 
        Version $version
    ): self
    {
        $instance = new self($id, $name, $url_vocabulary, $url_definitions, $url_search, $created_at, $update_at, $version);
        
        //TODO record message
        // $instance->recordThat(VocabulariesWasCreated::from($instance->id(), $instance->name()));

        return $instance;
    }

    /**
     * Used to hydrate an entity. Does not register events.
     */
    public static function from(
        VocabulariesId $id,
        VocabulariesName $name, 
        Url $url_vocabulary, 
        Url $url_definitions, 
        Url $url_search, 
        DateTimeInmutable $created_at, 
        DateTimeInmutable $update_at, 
        Version $version
    ): self
    {
        return new self($id, $name, $url_vocabulary, $url_definitions, $url_search, $created_at, $update_at, $version);
    }

    public function id(): VocabulariesId
    {
        return $this->id;
    }

    public function name(): VocabulariesName
    {
        return $this->name;
    }

    public function url_vocabulary(): Url
    {
        return $this->url_vocabulary;
    }

    public function url_definitions(): Url
    {
        return $this->url_definitions;
    }

    public function url_search(): Url
    {
        return $this->url_search;
    }

    public function created_at(): DateTimeInmutable
    {
        return $this->created_at;
    }

    public function update_at(): DateTimeInmutable
    {
        return $this->update_at;
    }

    public function version(): Version
    {
        return $this->version;
    }
    

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url_vocabulary' => $this->url_vocabulary,
            'url_definitions' => $this->url_definitions,
            'url_search' => $this->url_search,
            'created_at' => $this->created_at,
            'update_at' => $this->update_at,
            'version' => $this->version
        ];
    }
}