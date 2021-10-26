<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Exceptions\Api;

final class TagsResource extends AppResource
{
    private const RESOURCE_CODE = 5;
    private const RESOURCE_NAME = 'tags';

    public static function create(): self
    {
        return new self(self::RESOURCE_NAME, self::RESOURCE_CODE);
    }
}
