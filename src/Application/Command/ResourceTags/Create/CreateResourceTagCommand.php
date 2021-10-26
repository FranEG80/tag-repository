<?php
declare(strict_types=1);

namespace XTags\Application\Command\ResourceTags\Create;

use Assert\Assert;
use PcComponentes\Ddd\Application\Command;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Infrastructure\Message\Generator\Tags\TagsCommand;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class CreateResourceTagCommand extends Command
{
    private const NAME = 'create_resource_tag';
    private const VERSION = '1';

    private TagId $tagId;
    private ResourceTagId $resourceId;

    public static function create($resourceId, $tagId):self
    {
        return self::fromPayload(Uuid::v4(), [
            'tagId' => $tagId,
            'resourceId' => $resourceId,
        ]);
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function resourceId(): ResourceTagId
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
            ->that($payload['tagId'], 'tagId')->uuid()
            ->that($payload['resourceId'], 'resourceId')->uuid()
            ->verifyNow()
        ;

        $this->tagId = TagId::from($payload['tagId']);
        $this->resourceId = ResourceTagId::from($payload['resourceId']);        
    }
}
