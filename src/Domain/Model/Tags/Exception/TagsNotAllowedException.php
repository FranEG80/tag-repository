<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Tags\Exception;

use XTags\Infrastructure\Exceptions\Api\TagsResource;
use XTags\Shared\Infrastructure\Exceptions\ApiException;

class TagsNotAllowedException extends ApiException
{
    private const ERROR_CODE = 3;
    private const STATUS_CODE = 403;

    public function __construct(TagsResource $resource, array $data, string $message, ?\Throwable $previous = null)
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
