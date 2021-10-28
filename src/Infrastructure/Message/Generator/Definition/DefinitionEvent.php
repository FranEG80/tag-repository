<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Message\Generator\Definition;

use XTags\Domain\Model\Definition\Definition;
use XTags\Domain\Service\ServiceName;
use XTags\Shared\Domain\CompanyName;
use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\TopicGenerator\Topic;
use XTags\Domain\Model\Definition\Definition as DefinitionDefinition;

final class DefinitionEvent
{
    public static function topic(string $eventVersion, string $eventName)
    {
        return Topic::generate(
            CompanyName::instance(),
            ServiceName::instance(),
            $eventVersion,
            DomainEvent::messageType(),
            DefinitionDefinition::modelName(),
            $eventName,
        );
    }
}
