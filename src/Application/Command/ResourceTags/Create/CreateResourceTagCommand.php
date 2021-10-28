<?php
declare(strict_types=1);

namespace XTags\Application\Command\ResourceTags\Create;

use Assert\Assert;
use PcComponentes\Ddd\Application\Command;
use XTags\Domain\Model\ResourceTags\ValueObject\ExternalResourceId;
use XTags\Infrastructure\Message\Generator\Tags\TagsCommand;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Shared\Domain\Model\ValueObject\Version;

class CreateResourceTagCommand extends Command
{
    private const NAME = 'create_resource_tag';
    private const VERSION = '1';

    private ?Version $version;
    private ExternalResourceId $resourceId;

    public static function create($resourceId, $version):self
    {
        return self::fromPayload(Uuid::v4(), [
            'resourceId' => $resourceId,
            'version' => $version
        ]);
    }

    public function version(): ?Version
    {
        return $this->version;
    }

    public function resourceId(): ExternalResourceId
    {
        return $this->resourceId;
    }

    public static function messageName(): string
    {
        return TagsCommand::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
        $payload = $this->messagePayload();

        Assert::lazy()
            ->that($payload['version'], 'version')->nullOr()->string()
            ->that($payload['resourceId'], 'resourceId')->uuid()
            ->verifyNow()
        ;

        $this->version = $payload['version'] ? Version::from($payload['version']) : null;
        $this->resourceId = ExternalResourceId::from($payload['resourceId']);        
    }
}
