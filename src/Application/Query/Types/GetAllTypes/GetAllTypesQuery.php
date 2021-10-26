<?php

namespace XTags\Application\Query\Types\GetAllTypes;

use PcComponentes\Ddd\Application\Query;
use XTags\Infrastructure\Message\Generator\Types\TypesQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetAllTypesQuery extends Query
{
    private const NAME = 'find_all_types';
    private const VERSION = '1';

    public static function create():self
    {
        return self::fromPayload(Uuid::v4(), []);
    }

    public static function messageName(): string
    {
        return TypesQuery::topic(self::VERSION, self::NAME);
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
