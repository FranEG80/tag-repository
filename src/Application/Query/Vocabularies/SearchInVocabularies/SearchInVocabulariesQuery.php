<?php

namespace XTags\Application\Query\Vocabularies\SearchInVocabularies;

use Assert\Assert;
use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\Vocabularies\VocabulariesCollection;
use XTags\Infrastructure\Message\Generator\Vocabularies\VocabulariesQuery;

use XTags\Shared\Domain\Model\ValueObject\Uuid;

class SearchInVocabulariesQuery extends Query
{
    private const NAME = 'find_in_vocabularies';
    private const VERSION = '1';

    private string $vocabulary;
    private string $query;
    private string $mode;
    private string $langsearch;
    private string $langlabel;
    private string $schema;
    private bool $suggestions;

    private string $tag_id;

    public static function create(string $vocabulary, string $query, string $mode, string $langsearch, string $langlabel, string $schema, bool $suggestions, $id =''): self
    {
        $output = [
            'vocabulary' => $vocabulary,
            'query' => $query,
            'mode' => $mode,
            'langsearch' => $langsearch,
            'langlabel' => $langlabel,
            'schema' => $schema,
            'suggestions' => $suggestions,
            'tag_id' => $id
        ];

        $output['data'] = $query ? $query : [];

        return self::fromPayload(
            Uuid::v4(),
            $output
        );
    }

    public static function messageName(): string
    {
        return VocabulariesQuery::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
        $payload = $this->messagePayload();
        
        $this->vocabulary = $payload['vocabulary'];
        $this->query = $payload['query'];
        $this->mode = $payload['mode'];
        $this->langsearch = $payload['langsearch'];
        $this->langlabel = $payload['langlabel'];
        $this->schema = $payload['schema'];
        $this->suggestions = $payload['suggestions'];
        $this->tag_id = $payload['tag_id'] ? $payload['tag_id'] : '';

    }

    public function tag_id()
    {
        return $this->tag_id;
    }

    public function vocabulary(): string
    {
        return $this->vocabulary;
    }
 
    public function query(): string
    {
        return $this->query;
    }
 
    public function mode(): string
    {
        return $this->mode;
    }
 
    public function langsearch(): string
    {
        return $this->langsearch;
    }
 
    public function langlabel(): string
    {
        return $this->langlabel;
    }
 
    public function schema(): string
    {
        return $this->schema;
    }
 
    public function suggestions(): bool
    {
        return $this->suggestions;
    }
}
