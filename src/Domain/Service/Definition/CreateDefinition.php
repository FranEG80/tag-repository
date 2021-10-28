<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Definition;

use XTags\Domain\Model\Definition\Definition;
use XTags\Domain\Model\Definition\DefinitionRepository;
use XTags\Domain\Model\Definition\Exception\DefinitionAlreadyExistException;
use XTags\Domain\Model\Definition\ValueObject\DefinitionName;
use XTags\Infrastructure\Exceptions\Api\DefinitionResources;

class CreateDefinition
{
    private DefinitionRepository $repository;

    public function __construct(DefinitionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DefinitionName $name): Definition
    {
        $this->assertDefinitionDoesNotExists($name);

        $resourceTag = Definition::create($name);

        $this->repository->save($resourceTag);

        return $resourceTag;
    }

    public function assertDefinitionDoesNotExists(DefinitionName $name): void
    {
        if (null !== $this->repository->findByName($name)) {
            throw new DefinitionAlreadyExistException(DefinitionResources::create(), null);
        }
    }
}
