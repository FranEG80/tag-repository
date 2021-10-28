<?php
declare(strict_types=1);

namespace XTags\Application\Query\Definition\GetByName;

use Assert\Assert;
use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\Definition\ValueObject\DefinitionName;
use XTags\Infrastructure\Message\Generator\Definition\DefinitionQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetByNameQuery extends Query
{
    private const NAME = 'find_by_name';
    private const VERSION = '1';

    private ?DefinitionName $name;

    public static function create($name):self
    {
        return self::fromPayload(Uuid::v4(), [
            'name' => $name
        ]);
    }

    public function name()
    {
        return $this->name;
    }

    public static function messageName(): string
    {
        return DefinitionQuery::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
        $payload = $this->messagePayload();

        // Assert::lazy()
        //     ->that($payload['definitionId'], 'definitionId')->integer()
        //     ->verifyNow()
        ;

        $this->name = $payload['name'] ? DefinitionName::from((string )$payload['name']) : null;
    }
}
