<?php
declare(strict_types=1);

namespace XTags\Infrastructure\Domain\Model;

use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;
use XTags\Shared\Domain\Model\DomainModel;

interface DoctrineRepository
{
    
    public function save(): void;

    public function find(): ?DomainModel;

    public function findAll(): CollectionValueObject;

    public function entityToModel(): DomainModel;
    
    /**
     * @return Entity Doctrine
     */
    public function modelToEntity();
}
