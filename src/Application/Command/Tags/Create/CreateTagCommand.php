<?php
declare(strict_types=1);

namespace XTags\Application\Command\Tags\Create;

use Assert\Assert;
use PcComponentes\Ddd\Application\Command;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelId;
use XTags\Domain\Model\TagLabel\ValueObject\TagName;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Message\Generator\Tags\TagsCommand;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Shared\Domain\Model\ValueObject\Version;

class CreateTagCommand extends Command
{
    private const NAME = 'create_tag';
    private const VERSION = '1';

    private TagId $tagId;
    private TagName $customName;
    private ResourceTagId $resourceId;
    private VocabulariesId $vocabularyId;
    private LanguagesId $langId;
    private TypesId $typeId;
    private TagLabelId $tagLabelId;

    public static function create($customName, $resourceId, $vocabularyId, $langId, $typeId, TagLabelId $tagLabelId):self
    {
        return self::fromPayload(Uuid::v4(), [
            'customName' => $customName,
            'resourceId' => $resourceId,
            'vocabularyId' => $vocabularyId,
            'langId' => $langId,
            'typeId' => $typeId,
            'tagLabelId' => $tagLabelId
        ]);
    }

    public function tagId(): TagId
    {
        return $this->tagId;
    }

    public function customName(): TagName
    {
        return $this->customName;
    }

    public function resourceId(): ResourceTagId
    {
        return $this->resourceId;
    }

    public function vocabularyId(): VocabulariesId
    {
        return $this->vocabularyId;
    }

    public function langId(): LanguagesId
    {
        return $this->langId;
    }

    public function typeId(): TypesId
    {
        return $this->typeId;
    }

    public function tagLabelId(): TagLabelId
    {
        return $this->tagLabelId;
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
            ->that($payload['customName'], 'customName')->string()
            ->that($payload['resourceId'], 'resourceId')->uuid()
            ->that($payload['vocabularyId'], 'vocabularyId')->int()
            ->that($payload['langId'], 'langId')->int()
            ->that($payload['typeId'], 'typeId')->int()
            ->that($payload['tagLabelId'], 'tagLabelId')->string()
            ->verifyNow()
        ;

        $this->tagId = TagId::from($payload['tagId']);
        $this->customName = TagName::from($payload['customName']);
        $this->resourceId = ResourceTagId::from($payload['resourceId']);
        $this->vocabularyId = VocabulariesId::from($payload['vocabularyId']);
        $this->langId = LanguagesId::from($payload['langId']);
        $this->typeId = TypesId::from($payload['typeId']);
        $this->tagLabelId = TypesId::from($payload['tagLabelId']);
        
    }
}
