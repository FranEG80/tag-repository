<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Types;

use XTags\Domain\Model\Types\Types;
use XTags\Domain\Model\Types\TypesRepository;
use XTags\Domain\Model\Types\Exception\TypesDoesNotExistException;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Infrastructure\Exceptions\Api\TypesResource;

class ByIdTypesFinder
{
    private TypesRepository $typesRepository;

    public function __construct(TypesRepository $typesRepository)
    {
        $this->typesRepository = $typesRepository;
    }

    public function __invoke(TypesId $typesId): Types
    {
        $types = $this->typesRepository->find($typesId);

        if (null === $types) {
            throw new TypesDoesNotExistException(TypesResource::create());
        }

        return $types;
    }
}
