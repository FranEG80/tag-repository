<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Languages\Exception;

use XTags\Infrastructure\Exceptions\Api\LanguagesResource;
use XTags\Shared\Infrastructure\Exceptions\DoesNotExistsException;

class LanguagesDoesNotExistException extends DoesNotExistsException
{
    // This should be unique per exception. Understand this is NOT the HTTP STATUS CODE (which would be infrastructure).
    const ERROR_CODE = 2;
    
    public function __construct(LanguagesResource $resource, ?\Throwable $previous = null)
    {
        parent::__construct(
            $resource,
            self::ERROR_CODE,
            $previous,
        );
    }
}