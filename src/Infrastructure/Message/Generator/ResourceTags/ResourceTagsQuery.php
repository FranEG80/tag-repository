<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Message\Generator\ResourceTags;

use XTags\Domain\Model\ResourceTags\ResourceTags;
use XTags\Domain\Service\ServiceName;
use XTags\Shared\Domain\CompanyName;
use PcComponentes\Ddd\Application\Query;
use PcComponentes\TopicGenerator\Topic;

class ResourceTagsQuery
{
    public static function topic(string $queryVersion, string $queryName): string
    {
        return Topic::generate(
            CompanyName::instance(),
            ServiceName::instance(),
            $queryVersion,
            Query::messageType(),
            ResourceTags::modelName(),
            $queryName,
        );
    }
}
