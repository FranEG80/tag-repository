<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Exceptions\Api;

final class DefinitionResources extends AppResource
{
    private const RESOURCE_CODE = 1;
    private const RESOURCE_NAME = 'definition';

    public static function create(): self
    {
        return new self(self::RESOURCE_NAME, self::RESOURCE_CODE);
    }
}
