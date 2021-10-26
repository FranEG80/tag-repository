<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Types;

use XTags\Domain\Model\Types\Types;
use XTags\Domain\Model\Types\TypesCollection;
use XTags\Domain\Model\Types\TypesRepository;
use XTags\Domain\Model\Types\Exception\TypesDoesNotExistException;
use XTags\Infrastructure\Exceptions\Api\TypesResource;

class AllTypesFinder
{
    private TypesRepository $typesRepository;

    public function __construct(TypesRepository $typesRepository)
    {
        $this->typesRepository = $typesRepository;
    }

    public function __invoke(): TypesCollection
    {
        $types = $this->typesRepository->findAll();

        if (null === $types) {
            throw new TypesDoesNotExistException(TypesResource::create());
        }

        return $types;
    }
}
