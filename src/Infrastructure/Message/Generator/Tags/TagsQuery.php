<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Message\Generator\Tags;

use XTags\Domain\Model\Tags\Tags;
use XTags\Domain\Service\ServiceName;
use XTags\Shared\Domain\CompanyName;
use PcComponentes\Ddd\Application\Query;
use PcComponentes\TopicGenerator\Topic;

class TagsQuery
{
    public static function topic(string $queryVersion, string $queryName): string
    {
        return Topic::generate(
            CompanyName::instance(),
            ServiceName::instance(),
            $queryVersion,
            Query::messageType(),
            Tags::modelName(),
            $queryName,
        );
    }
}
