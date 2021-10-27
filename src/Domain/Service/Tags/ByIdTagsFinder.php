<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Tags;

use XTags\Domain\Model\Types\Types;
use XTags\Domain\Model\Types\TypesRepository;
use XTags\Domain\Model\Types\Exception\TypesDoesNotExistException;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Infrastructure\Exceptions\Api\TypesResources;

class ByIdTagsFinder
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
            throw new TypesDoesNotExistException(TypesResources::create());
        }

        return $tags;
    }
}
