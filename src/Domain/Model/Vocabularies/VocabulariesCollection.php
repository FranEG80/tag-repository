<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Vocabularies;

use Assert\Assertion;
use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;

final class VocabulariesCollection extends CollectionValueObject 
{

    private array $addedHashes = [];

    public static function from(array $items): self
    {
        Assertion::allIsInstanceOf($items, Vocabularies::class);

        return parent::from($items);
    }

    public function add(Vocabularies $vocabularies): self
    {
        $collection = $this->addItem($vocabularies);

        $addedHashes = $this->addedHashes;
        $addedHashes[] = \spl_object_hash($vocabularies);

        /** @phpstan-ignore-next-line */
        $collection->addedHashes = \array_unique($addedHashes);

        return $collection;
    }

    public function current(): ?Vocabularies
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
            static fn (Vocabularies $vocabularies) => \in_array(\spl_object_hash($vocabularies), $addedHashes, true),
        );
    }

    public function has(Vocabularies $vocabularies): bool
    {
        foreach ($this as $item) {
            if ($item->id()->equalTo($vocabularies->id())) {
                return true;
            }
        }

        return false;
    }
}