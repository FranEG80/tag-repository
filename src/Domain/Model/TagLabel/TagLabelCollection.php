<?php
declare(strict_types=1);

namespace XTags\Domain\Model\TagLabel;

use Assert\Assertion;
use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;

final class TagLabelCollection extends CollectionValueObject 
{

    private array $addedHashes = [];

    public static function from(array $items): self
    {
        Assertion::allIsInstanceOf($items, TagLabel::class);

        return parent::from($items);
    }

    public function add(TagLabel $tagLabels): self
    {
        $collection = $this->addItem($tagLabels);

        $addedHashes = $this->addedHashes;
        $addedHashes[] = \spl_object_hash($tagLabels);

        /** @phpstan-ignore-next-line */
        $collection->addedHashes = \array_unique($addedHashes);

        return $collection;
    }

    public function current(): ?TagLabel
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
            static fn (TagLabel $tagLabels) => \in_array(\spl_object_hash($tagLabels), $addedHashes, true),
        );
    }

    public function has(TagLabel $tagLabels): bool
    {
        foreach ($this as $item) {
            if ($item->id()->equalTo($tagLabels->id())) {
                return true;
            }
        }

        return false;
    }
}