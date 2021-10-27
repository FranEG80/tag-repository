<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Vocabularies;

use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesName;

interface VocabulariesRepository
{
    public function save(Vocabularies $vocabulary): void;

    public function find(VocabulariesId $vocabularyId): ?Vocabularies;

    public function findByName(VocabulariesName $name, $version): ?Vocabularies;

    public function findAll(): VocabulariesCollection;

    public function searchQuery(string $vocabulary, string $mode, string $query, string $langsearch, string $langlabel, bool $suggestions, $tag_id): array;
}