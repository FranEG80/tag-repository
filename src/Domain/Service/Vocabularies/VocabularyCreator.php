<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Vocabularies;

use XTags\Domain\Model\Vocabularies\Vocabularies;
use XTags\Domain\Model\Vocabularies\ValueObject\{VocabulariesId, VocabulariesName};
use XTags\Domain\Model\Vocabularies\Exception\VocabulariesAlreadyExistException;
use XTags\Domain\Model\Vocabularies\VocabulariesRepository;
use XTags\Infrastructure\Exceptions\Api\VocabulariesResource;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;
use XTags\Shared\Domain\Model\ValueObject\Url;
use XTags\Shared\Domain\Model\ValueObject\Version;

final class VocabularyCreator
{
    private VocabulariesRepository $repository;

    public function __construct(VocabulariesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(VocabulariesId $id, VocabulariesName $name, Url $url_vocabulary, Url $url_definitions, Url $url_search, DateTimeInmutable $created_at, DateTimeInmutable $update_at, Version $version): Vocabularies
    {
        $this->assertVocabulariesDoesNotExists($id);

        $vocabularies = Vocabularies::create($id, $name, $url_vocabulary, $url_definitions, $url_search, $created_at, $update_at, $version);

        $this->repository->save($vocabularies);

        return $vocabularies;
    }

    private function assertVocabulariesDoesNotExists(VocabulariesId $id): void
    {
        if (null !== $this->repository->find($id)) {
            throw new VocabulariesAlreadyExistException(VocabulariesResource::create(), null);
        }
    }
}
