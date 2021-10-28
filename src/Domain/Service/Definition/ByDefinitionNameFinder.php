<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Definition;

use XTags\Domain\Model\Definition\Definition;
use XTags\Domain\Model\Definition\DefinitionRepository;
use XTags\Domain\Model\Definition\ValueObject\DefinitionName;

class ByDefinitionNameFinder
{
    private DefinitionRepository $definitionRepository;

    public function __construct(DefinitionRepository $definitionRepository)
    {
        $this->definitionRepository = $definitionRepository;
    }

    public function __invoke(DefinitionName $name) //: DefinitionCollection
    {
        $definition = $this->definitionRepository->findByName($name);

        if (null === $definition) {
            $definition = Definition::create($name);
            $this->definitionRepository->save($definition);
        }
        return $definition;
    }
}