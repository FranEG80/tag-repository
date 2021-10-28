<?php
declare(strict_types=1); 

namespace XTags\Domain\Model\Definition;

use XTags\Domain\Model\Definition\ValueObject\DefinitionId;
use XTags\Domain\Model\Definition\ValueObject\DefinitionName;

interface DefinitionRepository
{
    public function save(Definition $definition): void;

    public function find(DefinitionId $definitionId): ?Definition;

    public function findAll(): DefinitionCollection;

    public function findByName(DefinitionName $definition): ?Definition;

}