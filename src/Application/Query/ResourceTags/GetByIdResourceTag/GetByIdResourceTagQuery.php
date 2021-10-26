<?php
declare(strict_types=1);

namespace XTags\Application\Query\ResourceTags\GetByIdResourceTag;

use PcComponentes\Ddd\Application\Query;
use XTags\Infrastructure\Message\Generator\ResourceTags\ResourceTagsQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetByIdResourceTagQuery extends Query
{
    private const NAME = 'find_one_resourceTag_by_id';
    private const VERSION = '1';

    public static function create():self
    {
        return self::fromPayload(Uuid::v4(), []);
    }

    public static function messageName(): string
    {
        return ResourceTagsQuery::topic(self::VERSION, self::NAME);
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
