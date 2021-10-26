<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Exceptions\Api;

final class VocabulariesResource extends AppResource
{
    private const RESOURCE_CODE = 3;
    private const RESOURCE_NAME = 'vocabulary';

    public static function create(): self
    {
        return new self(self::RESOURCE_NAME, self::RESOURCE_CODE);
    }
}
