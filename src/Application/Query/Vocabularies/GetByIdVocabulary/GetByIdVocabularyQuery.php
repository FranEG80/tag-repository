<?php
declare(strict_types=1);

namespace XTags\Application\Query\Vocabularies\GetByIdVocabulary;

use Assert\Assert;
use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Message\Generator\Vocabularies\VocabulariesQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;
use XTags\Shared\Domain\Model\ValueObject\Version;

class GetByIdVocabularyQuery extends Query
{

    private const NAME = 'find_one_vocabulary';
    private const VERSION = '1';

    private $id;

    public static function create($id):self
    {
        return self::fromPayload(Uuid::v4(), [
            'id' => $id
        ]);
    }

    public function id()
    {
        return $this->id;
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
            ->that($payload['id'], 'id')->integerish()
            ->verifyNow()
        ;

        $this->id = VocabulariesId::from($payload['id']);
    }
}
