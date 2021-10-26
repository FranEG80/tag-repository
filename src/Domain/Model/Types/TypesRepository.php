<?php
declare(strict_types=1); 

namespace XTags\Domain\Model\Types;

use XTags\Domain\Model\Types\ValueObject\TypesId;

interface TypesRepository
{
    public function save(Types $vocabulary): void;

    public function find(TypesId $vocabularyId): ?Types;

    public function findAll(): TypesCollection;
}