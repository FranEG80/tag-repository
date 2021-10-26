<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Vocabularies\Exception;

use XTags\Infrastructure\Exceptions\Api\VocabulariesResource;
use XTags\Shared\Infrastructure\Exceptions\AlreadyExistsException;

class VocabulariesAlreadyExistException extends AlreadyExistsException
{
    // This should be unique per exception. Understand this is NOT the HTTP STATUS CODE (which would be infrastructure).
    const ERROR_CODE = 1;
    
    public function __construct(VocabulariesResource $resource, ?\Throwable $previous = null)
    {
        parent::__construct(
            $resource,
            self::ERROR_CODE,
            $previous,
        );
    }
}