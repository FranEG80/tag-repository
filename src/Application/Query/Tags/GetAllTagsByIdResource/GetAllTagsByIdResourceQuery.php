<?php
declare(strict_types=1);

namespace XTags\Application\Query\Tags\GetAllTagsByIdResource;

use Assert\Assert;
use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Infrastructure\Message\Generator\Tags\TagsQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Shared\Domain\Model\ValueObject\Version;

class GetAllTagsByIdResourceQuery extends Query
{
    private const NAME = 'find_all_tags_by_resourceId';
    private const VERSION = '1';

    public static function create(ResourceTagId $resourceId, $version = null, $vocabulary = null, $language = null):self
    {
        return self::fromPayload(Uuid::v4(), [
            'resourceId' => $resourceId,
            'version' => $version,
            'vocabularyId' => $vocabulary,
            'languageId' => $language
        ]);
    }

    public static function messageName(): string
    {
        return TagsQuery::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
        $payload = $this->messagePayload();

        Assert::lazy()
            ->that($payload['resourceId'], 'resourceId')->uuid()
            ->that($payload['version'], 'version')->nullOr()->string()
            ->verifyNow()
        ;

        $this->resourceId = $payload['resourceId'];
        $this->version = $payload['version'] ? Version::from($payload['version']) : null;
    }
}
