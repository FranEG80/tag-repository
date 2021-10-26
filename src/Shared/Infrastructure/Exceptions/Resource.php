<?php
declare(strict_types=1);

namespace XTags\Shared\Infrastructure\Exceptions;

interface Resource
{
    public function resourceName(): string;

    public function resourceCode(): int;
}
