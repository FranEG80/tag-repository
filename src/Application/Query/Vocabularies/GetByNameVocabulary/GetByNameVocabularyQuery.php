<?php
declare(strict_types=1);

namespace XTags\Application\Query\Vocabularies\GetByNameVocabulary;

use Assert\Assert;
use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesName;
use XTags\Infrastructure\Message\Generator\Vocabularies\VocabulariesQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetByNameVocabularyQuery extends Query
{

    private const NAME = 'find_one_vocabulary_by_name';
    private const VERSION = '1';

    private $name;
    private $version;

    public static function create($name, $version = null):self
    {
        return self::fromPayload(Uuid::v4(), [
            'name' => $name,
            'version' => $version,
        ]);
    }

    public function name()
    {
        return $this->name;
    }

    public function version()
    {
        return $this->version;
    }

    public static function messageName(): string
    {
        return VocabulariesQuery::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
        $payload = $this->messagePayload();

        Assert::lazy()
            ->that($payload['name'], 'name')->string()
            ->that($payload['version'], 'version')->nullOr()->string()
            ->verifyNow()
        ;

        $this->name = VocabulariesName::from($payload['name']);
        $this->version = $payload['version'] ? VocabulariesName::from($payload['version']) : null;
    }
}
