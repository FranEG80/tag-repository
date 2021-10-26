<?php
declare(strict_types=1);

namespace XTags\Application\Command\TagLabel\Create;

use Assert\Assert;
use PcComponentes\Ddd\Application\Command;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\TagLabel\ValueObject\TagName;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Infrastructure\Message\Generator\TagLabel\TagLabelCommand;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class CreateTagLabelCommand extends Command
{
    private const NAME = 'create_tag_label';
    private const VERSION = '1';

    private TagId $tagId;
    private LanguagesId $langId;
    private TagName $name;

    public static function create( $tagId, $langId, $name):self
    {
        return self::fromPayload(Uuid::v4(), [
            'tagId' => $tagId,
            'langId' => $langId,
            'name' => $name,
        ]);
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function langId(): LanguagesId
    {
        return $this->langId;
    }

    public function name(): TagName
    {
        return $this->name;
    }

    public static function messageName(): string
    {
        return TagLabelCommand::topic(self::VERSION, self::NAME);
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
            ->that($payload['langId'], 'langId')->integer()
            ->that($payload['name'], 'name')->string()
            ->verifyNow()
        ;

        $this->tagId = TagId::from($payload['tagId']);
        $this->langId = LanguagesId::from($payload['langId']);        
        $this->langId = TagName::from($payload['name']);        
    }
}