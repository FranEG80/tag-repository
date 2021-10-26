<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Message\Generator\Tags;

use XTags\Domain\Model\Tags\Tags;
use XTags\Domain\Service\ServiceName;
use XTags\Shared\Domain\CompanyName;
use PcComponentes\Ddd\Application\Command;
use PcComponentes\TopicGenerator\Topic;

final class TagsCommand
{
    public static function topic(string $commandVersion, string $commandName): string
    {
        return Topic::generate(
            CompanyName::instance(),
            ServiceName::instance(),
            $commandVersion,
            Command::messageType(),
            Tags::modelName(),
            $commandName,
        );
    }
}
