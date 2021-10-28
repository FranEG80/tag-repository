<?php
declare(strict_types=1);

namespace XTags\Application\Query\Languages\GetByNameLanguage;

use Assert\Assert;
use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Infrastructure\Message\Generator\Languages\LanguagesQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetByNameLanguageQuery extends Query
{
    private const NAME = 'find_language';
    private const VERSION = '1';

    public static function create($id):self
    {
        return self::fromPayload(Uuid::v4(), [
            'id' => $id
        ]);
    }

    public function id()
    {
        $this->id;
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
