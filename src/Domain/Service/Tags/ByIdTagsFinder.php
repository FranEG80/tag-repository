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
    private TypesRepository $tagsRepository;

    public function __construct(TypesRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    public function __invoke(TypesId $tagsId): Types
    {
        $tags = $this->tagsRepository->find($tagsId);

        if (null === $tags) {
            throw new TypesDoesNotExistException(TypesResource::create());
        }

        return $tags;
    }
}
