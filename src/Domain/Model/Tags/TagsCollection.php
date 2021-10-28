<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Tags;

use Assert\Assertion;
use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;
use XTags\Domain\Model\Definition\ValueObject\DefinitionId;

final class TagsCollection extends CollectionValueObject 
{

    private array $addedHashes = [];

    public static function from(array $items): self
    {
        Assertion::allIsInstanceOf($items, Tags::class);

        return parent::from($items);
    }

    public function add(Tags $tags): self
    {
        $collection = $this->addItem($tags);

        $addedHashes = $this->addedHashes;
        $addedHashes[] = \spl_object_hash($tags);

        /** @phpstan-ignore-next-line */
        $collection->addedHashes = \array_unique($addedHashes);

        return $collection;
    }

    public function current(): ?Tags
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
            static fn (Tags $tags) => \in_array(\spl_object_hash($tags), $addedHashes, true),
        );
    }

    public function has(Tags $tags): bool
    {
        foreach ($this as $item) {
            if ($item->id()->equalTo($tags->id())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Tags|string $tag
     */
    public function hasDefinition($tag): bool
    {
        $definition = $tag instanceof Tags ? $tag->definitionId() : DefinitionId::from((int) $tag);
        foreach ($this as $item) {
            if ($item->definitionId()->equalTo($definition)) {
                return true;
            }
        }

        return false;
    }
}