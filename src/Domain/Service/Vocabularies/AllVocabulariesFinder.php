<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Vocabularies;

use XTags\Domain\Model\Vocabularies\Vocabularies;
use XTags\Domain\Model\Vocabularies\VocabulariesCollection;
use XTags\Domain\Model\Vocabularies\VocabulariesRepository;
use XTags\Domain\Model\Vocabularies\Exception\VocabulariesDoesNotExistException;
use XTags\Infrastructure\Exceptions\Api\VocabulariesResource;

class AllVocabulariesFinder
{
    private VocabulariesRepository $vocabulariesRepository;

    public function __construct(VocabulariesRepository $vocabulariesRepository)
    {
        $this->vocabulariesRepository = $vocabulariesRepository;
    }

    public function __invoke(): VocabulariesCollection
    {
        $vocabularies = $this->vocabulariesRepository->findAll();

        if (null === $vocabularies) {
            throw new VocabulariesDoesNotExistException(VocabulariesResource::create());
        }

        return $vocabularies;
    }
}
