<?php
declare(strict_types=1);

namespace XTags\Domain\Model\TagLabel\Exception;

use XTags\Infrastructure\Exceptions\Api\TagLabelResources;
use XTags\Shared\Infrastructure\Exceptions\AlreadyExistsException;

class TagLabelAlreadyExistException extends AlreadyExistsException
{
    // This should be unique per exception. Understand this is NOT the HTTP STATUS CODE (which would be infrastructure).
    const ERROR_CODE = 1;
    
    public function __construct(TagLabelResources $resource, ?\Throwable $previous = null)
    {
        parent::__construct(
            $resource,
            self::ERROR_CODE,
            $previous,
        );
    }
}