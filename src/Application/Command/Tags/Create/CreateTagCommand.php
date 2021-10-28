<?php
declare(strict_types=1);

namespace XTags\Application\Command\Tags\Create;

use Assert\Assert;
use PcComponentes\Ddd\Application\Command;
use XTags\Domain\Model\Definition\ValueObject\DefinitionId;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\Tags\ValueObject\TagName;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Message\Generator\Tags\TagsCommand;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Shared\Domain\Model\ValueObject\Version;

class CreateTagCommand extends Command
{
    private const NAME = 'create_tag_label';
    private const VERSION = '1';

    private LanguagesId $langId;
    private VocabulariesId $vocabularyId;
    private DefinitionId $definitionId;
    private Version $version;
    private TagName $name;

    public static function create($langId, $vocabularyId, $definitionId, $name, $version):self
    {
        return self::fromPayload(Uuid::v4(), [
            'langId' => $langId,
            'vocabularyId' => $vocabularyId,
            'definitionId' => $definitionId,
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

    public function name(): TagName
    {
        return $this->name;
    }

    public function version(): Version
    {
        return $this->version;
    }

    public function definitionId(): DefinitionId
    {
        return $this->definitionId;
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

        $this->langId = LanguagesId::from($payload['langId']);        
        $this->vocabularyId = VocabulariesId::from($payload['vocabularyId']);        
        $this->definitionId = DefinitionId::from($payload['definitionId']);        
        $this->name = TagName::from($payload['name']);        
        $this->version = Version::from($payload['version']);        
    }
}