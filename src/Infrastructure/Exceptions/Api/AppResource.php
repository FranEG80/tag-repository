<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Exceptions\Api;

use XTags\Shared\Infrastructure\Exceptions\Resource;

abstract class AppResource implements Resource
{
    private string $name;
    private int $code;

    protected function __construct(string $name, int $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    public function resourceName(): string
    {
        return $this->name;
    }

    public function resourceCode(): int
    {
        return $this->code;
    }
}
