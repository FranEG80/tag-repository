<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Message\Generator\ResourceTags;

use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Service\ServiceName;
use XTags\Shared\Domain\CompanyName;
use PcComponentes\Ddd\Application\Command;
use PcComponentes\TopicGenerator\Topic;

final class ResourceTagsCommand
{
    public static function topic(string $commandVersion, string $commandName): string
    {
        return Topic::generate(
            CompanyName::instance(),
            ServiceName::instance(),
            $commandVersion,
            Command::messageType(),
            ResourceTags::modelName(),
            $commandName,
        );
    }
}
