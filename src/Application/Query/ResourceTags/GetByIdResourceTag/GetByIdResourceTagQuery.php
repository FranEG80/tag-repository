<?php
declare(strict_types=1);

namespace XTags\Application\Query\ResourceTags\GetByIdResourceTag;

use Assert\Assert;
use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalResourceId;
use XTags\Infrastructure\Message\Generator\ResourceTags\ResourceTagsQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Shared\Domain\Model\ValueObject\Version;

class GetByIdResourceTagQuery extends Query
{
    private const NAME = 'find_one_resourceTag_by_id';
    private const VERSION = '1';

    private ExternalResourceId $resourceId;
    private ?Version $version;

    public static function create($resourceId, $version):self
    {
        return self::fromPayload(Uuid::v4(), [
            'resourceId' => $resourceId,
            'version' => $version
        ]);
    }

    public function resourceId()
    {
        return $this->resourceId;
    }

    public function version()
    {
        return $this->version;
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

        Assert::lazy()
            ->that($payload['resourceId'], 'resourceId')->uuid()
            ->that($payload['version'], 'version')->nullOr()->string()
            ->verifyNow()
        ;

        $this->resourceId = ExternalResourceId::from($payload['resourceId']);
        $this->version = $payload['version'] ? Version::from($payload['version']) : null;
    }

}
