<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Exceptions\Api;

final class TypesResources extends AppResource
{
    private const RESOURCE_CODE = 5;
    private const RESOURCE_NAME = 'types';

    public static function create(): self
    {
        return new self(self::RESOURCE_NAME, self::RESOURCE_CODE);
    }
}
