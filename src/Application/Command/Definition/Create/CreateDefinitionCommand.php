<?php
declare(strict_types=1);

namespace XTags\Application\Command\Definition\Create;

use Assert\Assert;
use PcComponentes\Ddd\Application\Command;
use XTags\Domain\Model\Definition\ValueObject\DefinitionName;
use XTags\Infrastructure\Message\Generator\Tags\TagsCommand;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class CreateDefinitionCommand extends Command
{
    private const NAME = 'create_definition';
    private const VERSION = '1';

    private DefinitionName $name;

    public static function create($name):self
    {
        return self::fromPayload(Uuid::v4(), [
            'name' => $name
        ]);
    }


    public function name(): DefinitionName
    {
        return $this->name;
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
        //     ->that($payload['name'], 'name')->uuid()
        //     ->verifyNow()
        // ;

        $this->name = DefinitionName::from($payload['name']);        
    }
}
