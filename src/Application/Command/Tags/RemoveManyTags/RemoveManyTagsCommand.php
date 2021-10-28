<?php
declare(strict_types=1);

namespace XTags\Application\Command\Tags\RemoveManyTags;

use Assert\Assert;
use PcComponentes\Ddd\Application\Command;
use XTags\Infrastructure\Message\Generator\Tags\TagsCommand;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class RemoveManyTagsCommand extends Command
{
    private const NAME = 'remove_many_tags';
    private const VERSION = '1';

    private array $tags;

    public static function create($tags):self
    {
        return self::fromPayload(Uuid::v4(), [
            'tags' => $tags
        ]);
    }

    public function tags(): array
    {
        return $this->tags;
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

        // Assert::lazy()
        //     ->that($payload['tagId'], 'tagId')->uuid()
        //     ->that($payload['langId'], 'langId')->integer()
        //     ->that($payload['name'], 'name')->string()
        //     ->verifyNow()
        // ;

        $this->tags =$payload['tags'];        
    }
}