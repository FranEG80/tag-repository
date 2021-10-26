<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Message\Generator\ResourceTags;

use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Service\ServiceName;
use XTags\Shared\Domain\CompanyName;
use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\TopicGenerator\Topic;

final class ResourceTagsEvent
{
    public static function topic(string $eventVersion, string $eventName)
    {
        return Topic::generate(
            CompanyName::instance(),
            ServiceName::instance(),
            $eventVersion,
            DomainEvent::messageType(),
            ResourceTags::modelName(),
            $eventName,
        );
    }
}
