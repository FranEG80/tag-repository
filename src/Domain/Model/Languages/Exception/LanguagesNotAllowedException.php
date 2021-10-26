<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Languages\Exception;

use XTags\Infrastructure\Exceptions\Api\LanguagesResource;
use XTags\Shared\Infrastructure\Exceptions\ApiException;

class LanguagesNotAllowedException extends ApiException
{
    private const ERROR_CODE = 3;
    private const STATUS_CODE = 403;

    public function __construct(LanguagesResource $resource, array $data, string $message, ?\Throwable $previous = null)
    {
        parent::__construct(
            self::STATUS_CODE,
            $resource,
            self::ERROR_CODE,
            $data,
            $message,
            $previous,
        );
    }
}
