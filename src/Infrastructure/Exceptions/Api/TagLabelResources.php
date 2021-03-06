<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Exceptions\Api;

final class TagLabelResources extends AppResource
{
    private const RESOURCE_CODE = 4;
    private const RESOURCE_NAME = 'tag_labels';

    public static function create(): self
    {
        return new self(self::RESOURCE_NAME, self::RESOURCE_CODE);
    }
}
