<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Message\Generator\Languages;

use XTags\Domain\Model\Languages\Languages;
use XTags\Domain\Service\ServiceName;
use XTags\Shared\Domain\CompanyName;
use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\TopicGenerator\Topic;

final class LanguagesEvent
{
    public static function topic(string $eventVersion, string $eventName)
    {
        return Topic::generate(
            CompanyName::instance(),
            ServiceName::instance(),
            $eventVersion,
            DomainEvent::messageType(),
            Languages::modelName(),
            $eventName,
        );
    }
}
