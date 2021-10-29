<?php
declare(strict_types=1);

namespace XTags\Application\Command\Tags\Create;

use Assert\Assert;
use PcComponentes\Ddd\Application\Command;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\ValueObject\DefinitionName;
use XTags\Domain\Model\Tags\ValueObject\TagName;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Message\Generator\Tags\TagsCommand;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Shared\Domain\Model\ValueObject\Version;

class CreateTagCommand extends Command
{
    private const NAME = 'create_tag_label';
    private const VERSION = '1';

    private DefinitionName $definition;
    private ResourceTagId $resourceId;
    private VocabulariesId $vocabularyId;
    private Version $version;
    private TagName $name;

    public static function create($definition, $resourceId, $vocabularyId, $version,  $name, $typesId):self
    {
        return self::fromPayload(Uuid::v4(), [
            'definition' => $definition,
            'resourceId' => $resourceId,
            'vocabularyId' => $vocabularyId,
            'name' => $name,
            'version' => $version,
            'typesId' => $typesId
        ]);
    }

    public function definition(): ?DefinitionName
    {
        return $this->definition;
    }

    public function vocabularyId(): VocabulariesId
    {
        return $this->vocabularyId;
    }

    public function resourceId(): ResourceTagId
    {
        return $this->resourceId;
    }

    public function name(): TagName
    {
        return $this->name;
    }

    public function version(): Version
    {
        return $this->version;
    }

    public function typesId(): TypesId
    {
        return $this->typesId;
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
        //     ->that($payload['definition'], 'definition')->uuid()
        //     ->that($payload['langId'], 'langId')->integer()
        //     ->that($payload['name'], 'name')->string()
        //     ->verifyNow()
        // ;

        $this->definition = DefinitionName::from((string) $payload['definition']);
        $this->resourceId = ResourceTagId::from((string) $payload['resourceId']);
        $this->vocabularyId = VocabulariesId::from($payload['vocabularyId']);
        $this->name = TagName::from($payload['name']);
        $this->version = Version::from((string) $payload['version']);
        $this->typesId = TypesId::from((int) $payload['typesId']);
    }
}