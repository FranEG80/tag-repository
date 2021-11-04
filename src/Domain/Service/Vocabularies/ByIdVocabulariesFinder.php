<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Vocabularies;

use XTags\Domain\Model\Vocabularies\Vocabularies;
use XTags\Domain\Model\Vocabularies\VocabulariesRepository;
use XTags\Domain\Model\Vocabularies\Exception\VocabulariesDoesNotExistException;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Exceptions\Api\VocabulariesResource;
use XTags\Shared\Domain\Model\ValueObject\Version;

class ByIdVocabulariesFinder
{
    private VocabulariesRepository $vocabulariesRepository;

    public function __construct(VocabulariesRepository $vocabulariesRepository)
    {
        $this->vocabulariesRepository = $vocabulariesRepository;
    }

    public function __invoke(VocabulariesId $vocabulariesId): Vocabularies
    {
        $vocabularies = $this->vocabulariesRepository->find($vocabulariesId);

        if (null === $vocabularies) {
            throw new VocabulariesDoesNotExistException(VocabulariesResource::create());
        }

        return $vocabularies;
    }
}
