<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Exceptions\Api;

final class ResourceTagsResource extends AppResource
{
    private const RESOURCE_CODE = 2;
    private const RESOURCE_NAME = 'resourceTags';

    public static function create(): self
    {
        return new self(self::RESOURCE_NAME, self::RESOURCE_CODE);
    }
}
