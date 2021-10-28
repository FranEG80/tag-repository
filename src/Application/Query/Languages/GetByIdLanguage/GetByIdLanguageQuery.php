<?php
declare(strict_types=1);

namespace XTags\Application\Query\Languages\GetByIdLanguage;

use Assert\Assert;
use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Infrastructure\Message\Generator\Languages\LanguagesQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetByIdLanguageQuery extends Query
{
    private const NAME = 'find_language';
    private const VERSION = '1';

    private ?LanguagesId $id;

    public static function create($id):self
    {
        return self::fromPayload(Uuid::v4(), [
            'id' => $id
        ]);
    }

    public function id(): ?LanguagesId
    {
        return $this->id;
    }

    public static function messageName(): string
    {
        return LanguagesQuery::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
        $payload = $this->messagePayload();

        Assert::lazy()
            ->that($payload['id'], 'id')->integer()
            ->verifyNow()
        ;

        $this->id = LanguagesId::from($payload['id']);
    }
}
