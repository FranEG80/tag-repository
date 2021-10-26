<?php
declare(strict_types=1);

namespace XTags\Domain\Model\TagLabel\Exception;

use XTags\Infrastructure\Exceptions\Api\TagLabelResources;
use XTags\Shared\Infrastructure\Exceptions\ApiException;

class TagLabelNotAllowedException extends ApiException
{
    private const ERROR_CODE = 3;
    private const STATUS_CODE = 403;

    public function __construct(TagLabelResources $resource, array $data, string $message, ?\Throwable $previous = null)
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
