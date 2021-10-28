<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Message\Generator\Definition;

use XTags\Domain\Model\Definition\Definition;
use XTags\Domain\Service\ServiceName;
use XTags\Shared\Domain\CompanyName;
use PcComponentes\Ddd\Application\Query;
use PcComponentes\TopicGenerator\Topic;

class DefinitionQuery
{
    public static function topic(string $queryVersion, string $queryName): string
    {
        return Topic::generate(
            CompanyName::instance(),
            ServiceName::instance(),
            $queryVersion,
            Query::messageType(),
            Definition::modelName(),
            $queryName,
        );
    }
}
