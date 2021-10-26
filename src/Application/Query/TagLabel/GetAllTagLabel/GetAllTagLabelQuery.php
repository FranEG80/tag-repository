<?php

namespace XTags\Application\Query\TagLabel\GetAllTagLabel;

use PcComponentes\Ddd\Application\Query;
use XTags\Infrastructure\Message\Generator\TagLabel\TagLabelQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetAllTagLabelQuery extends Query
{
    private const NAME = 'find_all_tagLabel';
    private const VERSION = '1';

    public static function create():self
    {
        return self::fromPayload(Uuid::v4(), []);
    }

    public static function messageName(): string
    {
        return TagLabelQuery::topic(self::VERSION, self::NAME);
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
