<?php
declare(strict_types=1);

namespace XTags\Application\Command\TagLabel\Create;

use Assert\Assert;
use PcComponentes\Ddd\Application\Command;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\TagLabel\ValueObject\LabelName;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Message\Generator\TagLabel\TagLabelCommand;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Shared\Domain\Model\ValueObject\Version;

class CreateTagLabelCommand extends Command
{
    private const NAME = 'create_tag_label';
    private const VERSION = '1';

    private LanguagesId $langId;
    private VocabulariesId $vocabularyId;
    private ?Version $version;
    private ?LabelName $name;

    public static function create($langId, $vocabularyId, $name, $version):self
    {
        return self::fromPayload(Uuid::v4(), [
            'langId' => $langId,
            'vocabularyId' => $vocabularyId,
            'name' => $name,
            'version' => $version,
        ]);
    }

    public function vocabularyId(): VocabulariesId
    {
        return $this->vocabularyId;
    }

    public function langId(): LanguagesId
    {
        return $this->langId;
    }

    public function name(): ?LabelName
    {
        return $this->name;
    }

    public function version(): ?Version
    {
        return $this->version;
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

        // Assert::lazy()
        //     ->that($payload['tagId'], 'tagId')->uuid()
        //     ->that($payload['langId'], 'langId')->integer()
        //     ->that($payload['name'], 'name')->string()
        //     ->verifyNow()
        // ;

        $this->langId = LanguagesId::from($payload['langId']);
        $this->vocabularyId = VocabulariesId::from($payload['vocabularyId']);
        $this->name = $payload['name'] ?  LabelName::from($payload['name']) : null;
        $this->version = $payload['version'] ? Version::from($payload['version']) : null;
    }
}