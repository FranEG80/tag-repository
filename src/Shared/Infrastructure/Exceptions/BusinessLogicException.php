<?php
declare(strict_types=1);

namespace XTags\Shared\Infrastructure\Exceptions;


abstract class BusinessLogicException extends ApiException
{
    private const STATUS_CODE = 400;

    public function __construct(
        Resource $resource,
        int $errorCode,
        array $extraData,
        string $message,
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            self::STATUS_CODE,
            $resource,
            $errorCode,
            $extraData,
            $message,
            $previous,
        );
    }
}
