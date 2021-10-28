<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Definition;

use Assert\Assertion;
use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;

final class DefinitionCollection extends CollectionValueObject 
{

    private array $addedHashes = [];

    public static function from(array $items): self
    {
        Assertion::allIsInstanceOf($items, Definition::class);

        return parent::from($items);
    }

    public function add(Definition $definition): self
    {
        $collection = $this->addItem($definition);

        $addedHashes = $this->addedHashes;
        $addedHashes[] = \spl_object_hash($definition);

        /** @phpstan-ignore-next-line */
        $collection->addedHashes = \array_unique($addedHashes);

        return $collection;
    }

    public function current(): ?Definition
    {
        $item = parent::current();

        if (false === $item) {
            return null;
        }

        return $item;
    }

    public function filterByAdded(): self
    {
        $addedHashes = $this->addedHashes;

        return $this->filter(
            static fn (Definition $definition) => \in_array(\spl_object_hash($definition), $addedHashes, true),
        );
    }

    public function has(Definition $definition): bool
    {
        foreach ($this as $item) {
            if ($item->id()->equalTo($definition->id())) {
                return true;
            }
        }

        return false;
    }
}