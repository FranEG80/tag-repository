<?php
declare(strict_types=1);

namespace XTags\Application\Query\Tags\GetAllTagsByIdResource;

use Assert\Assert;
use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Message\Generator\Tags\TagsQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Shared\Domain\Model\ValueObject\Version;

class GetAllTagsByIdResourceQuery extends Query
{
    private const NAME = 'find_all_tags_by_resourceId';
    private const VERSION = '1';

    private ResourceTagId $resourceId;
    private ?VocabulariesId $vocabularyId;
    private ?Version $version;

    public static function create($resourceId, $version, $vocabulary):self
    {
        return self::fromPayload(Uuid::v4(), [
            'resourceId' => $resourceId,
            'version' => $version,
            'vocabularyId' => $vocabulary,
        ]);
    }

    public function resourceId()
    {
        return $this->resourceId;
    }
    
    public function vocabularyId()
    {
        return $this->vocabularyId;
    }

    public function version()
    {
        return $this->version;
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
            ->that($payload['vocabularyId'], 'vocabularyId')->nullOr()->integer()
            ->verifyNow()
        ;
        
        $this->resourceId = ResourceTagId::from($payload['resourceId']);
        $this->version = $payload['version'] ? Version::from($payload['version']) : null;
        $this->vocabularyId = $payload['vocabularyId'] ? VocabulariesId::from($payload['vocabularyId']) : null;
    }
}
