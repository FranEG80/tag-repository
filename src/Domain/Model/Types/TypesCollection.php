<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Types;

use Assert\Assertion;
use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;

final class TypesCollection extends CollectionValueObject 
{

    private array $addedHashes = [];

    public static function from(array $items): self
    {
        Assertion::allIsInstanceOf($items, Types::class);

        return parent::from($items);
    }

    public function add(Types $types): self
    {
        $collection = $this->addItem($types);

        $addedHashes = $this->addedHashes;
        $addedHashes[] = \spl_object_hash($types);

        /** @phpstan-ignore-next-line */
        $collection->addedHashes = \array_unique($addedHashes);

        return $collection;
    }

    public function current(): ?Types
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
            static fn (Types $types) => \in_array(\spl_object_hash($types), $addedHashes, true),
        );
    }

    public function has(Types $types): bool
    {
        foreach ($this as $item) {
            if ($item->id()->equalTo($types->id())) {
                return true;
            }
        }

        return false;
    }
}