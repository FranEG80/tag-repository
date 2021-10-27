<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Vocabularies;

use XTags\Domain\Model\Vocabularies\Vocabularies;
use XTags\Domain\Model\Vocabularies\VocabulariesRepository;
use XTags\Domain\Model\Vocabularies\Exception\VocabulariesDoesNotExistException;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesName;
use XTags\Infrastructure\Exceptions\Api\VocabulariesResource;
use XTags\Shared\Domain\Model\ValueObject\Version;

class ByNameVocabularyFinder
{
    private VocabulariesRepository $vocabulariesRepository;

    public function __construct(VocabulariesRepository $vocabulariesRepository)
    {
        $this->vocabulariesRepository = $vocabulariesRepository;
    }

    public function __invoke(VocabulariesName $vocabulariesName, $version): Vocabularies
    {
        if (null === $version) $version = Version::from(Vocabularies::CURRENT_VERSION);

        $vocabulary = $this->vocabulariesRepository->findByName($vocabulariesName, $version);

        if (null === $vocabulary) {
            throw new VocabulariesDoesNotExistException(VocabulariesResource::create());
        }

        return $vocabulary;
    }
}
