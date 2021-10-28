<?php

namespace XTags\Application\Query\Languages\GetAllLanguages;

use PcComponentes\Ddd\Application\Query;
use XTags\Infrastructure\Message\Generator\Languages\LanguagesQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetAllLanguagesQuery extends Query
{
    private const NAME = 'find_all_languages';
    private const VERSION = '1';

    public static function create():self
    {
        return self::fromPayload(Uuid::v4(), []);
    }

    public static function messageName(): string
    {
        return LanguagesQuery::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
    }
}
