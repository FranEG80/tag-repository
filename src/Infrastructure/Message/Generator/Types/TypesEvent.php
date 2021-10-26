<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Message\Generator\Types;

use XTags\Domain\Model\Types\Types;
use XTags\Domain\Service\ServiceName;
use XTags\Shared\Domain\CompanyName;
use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\TopicGenerator\Topic;

final class TypesEvent
{
    public static function topic(string $eventVersion, string $eventName)
    {
        return Topic::generate(
            CompanyName::instance(),
            ServiceName::instance(),
            $eventVersion,
            DomainEvent::messageType(),
            Types::modelName(),
            $eventName,
        );
    }
}
