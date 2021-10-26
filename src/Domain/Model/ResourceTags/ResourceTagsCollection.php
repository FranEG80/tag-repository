<?php
declare(strict_types=1);

namespace XTags\Domain\Model\ResourceTags;

use Assert\Assertion;
use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;

final class ResourceTagsCollection extends CollectionValueObject 
{

    private array $addedHashes = [];

    public static function from(array $items): self
    {
        Assertion::allIsInstanceOf($items, ResourceTags::class);

        return parent::from($items);
    }

    public function add(ResourceTags $resourceTag): self
    {
        $collection = $this->addItem($resourceTag);

        $addedHashes = $this->addedHashes;
        $addedHashes[] = \spl_object_hash($resourceTag);

        /** @phpstan-ignore-next-line */
        $collection->addedHashes = \array_unique($addedHashes);

        return $collection;
    }

    public function current(): ?ResourceTags
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
            static fn (ResourceTags $resourceTag) => \in_array(\spl_object_hash($resourceTag), $addedHashes, true),
        );
    }

    public function has(ResourceTags $resourceTag): bool
    {
        foreach ($this as $item) {
            if ($item->resourceId()->equalTo($resourceTag->resourceId())) {
                return true;
            }
        }

        return false;
    }
}