<?php

namespace XTags\Application\Query\Vocabularies\GetAllVocabularies;

use PcComponentes\Ddd\Application\Query;
use XTags\Infrastructure\Message\Generator\Vocabularies\VocabulariesQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetAllVocabulariesQuery extends Query
{
    private const NAME = 'find_all_vocabularies';
    private const VERSION = '1';

    public static function create():self
    {
        return self::fromPayload(Uuid::v4(), []);
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
    }
}
