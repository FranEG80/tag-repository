<?php

namespace XTags\Application\Query\TagLabel\GetTagLabelByDefinitionId;

use PcComponentes\Ddd\Application\Query;
use XTags\Domain\Model\Definition\ValueObject\DefinitionId;
use XTags\Infrastructure\Message\Generator\TagLabel\TagLabelQuery;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

class GetTagLabelByDefinitionIdQuery extends Query
{
    private const NAME = 'find_tagLabel_by_definition_id';
    private const VERSION = '1';

    private DefinitionId $definitionId;

    public static function create(DefinitionId $definitionId):self
    {
        return self::fromPayload(Uuid::v4(), [
            'definitionId' => $definitionId->value()
        ]);
    }

    public function definitionId(): DefinitionId
    {
        return $this->definitionId;
    }

    public static function messageName(): string
    {
        return TagLabelQuery::topic(self::VERSION, self::NAME);
    }

    public static function messageVersion(): string
    {
        return self::VERSION;
    }

    protected function assertPayload(): void
    {
        $payload = $this->messagePayload();

        $this->definitionId = $payload['definitionId'] ? DefinitionId::from($payload['definitionId']) : null;
    }

}
