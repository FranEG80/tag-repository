<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Languages;

use Assert\Assertion;
use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;

final class LanguagesCollection extends CollectionValueObject 
{

    private array $addedHashes = [];

    public static function from(array $items): self
    {
        Assertion::allIsInstanceOf($items, Languages::class);

        return parent::from($items);
    }

    public function add(Languages $languages): self
    {
        $collection = $this->addItem($languages);

        $addedHashes = $this->addedHashes;
        $addedHashes[] = \spl_object_hash($languages);

        /** @phpstan-ignore-next-line */
        $collection->addedHashes = \array_unique($addedHashes);

        return $collection;
    }

    public function current(): ?Languages
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
            static fn (Languages $languages) => \in_array(\spl_object_hash($languages), $addedHashes, true),
        );
    }

    public function has(Languages $languages): bool
    {
        foreach ($this as $item) {
            if ($item->id()->equalTo($languages->id())) {
                return true;
            }
        }

        return false;
    }
}