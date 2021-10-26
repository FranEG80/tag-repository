<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Types\Exception;

use XTags\Infrastructure\Exceptions\Api\TypesResource;
use XTags\Shared\Infrastructure\Exceptions\AlreadyExistsException;

class TypesAlreadyExistException extends AlreadyExistsException
{
    // This should be unique per exception. Understand this is NOT the HTTP STATUS CODE (which would be infrastructure).
    const ERROR_CODE = 1;
    
    public function __construct(TypesResource $resource, ?\Throwable $previous = null)
    {
        parent::__construct(
            $resource,
            self::ERROR_CODE,
            $previous,
        );
    }
}