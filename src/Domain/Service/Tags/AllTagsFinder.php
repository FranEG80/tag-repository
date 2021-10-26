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
    private TypesRepository $tagsRepository;

    public function __construct(TypesRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    public function __invoke(): TypesCollection
    {
        $tags = $this->tagsRepository->findAll();

        if (null === $tags) {
            throw new TypesDoesNotExistException(TypesResource::create());
        }

        return $tags;
    }
}
