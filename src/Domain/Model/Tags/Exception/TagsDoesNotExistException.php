<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Tags\Exception;

use XTags\Infrastructure\Exceptions\Api\TagsResources;
use XTags\Shared\Infrastructure\Exceptions\DoesNotExistsException;

class TagsDoesNotExistException extends DoesNotExistsException
{
    // This should be unique per exception. Understand this is NOT the HTTP STATUS CODE (which would be infrastructure).
    const ERROR_CODE = 2;
    
    public function __construct(TagsResources $resource, ?\Throwable $previous = null)
    {
        parent::__construct(
            $resource,
            self::ERROR_CODE,
            $previous,
        );
    }
}