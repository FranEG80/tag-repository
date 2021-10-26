<?php
declare(strict_types=1); 

namespace XTags\Domain\Model\TagLabel;

use XTags\Domain\Model\TagLabel\ValueObject\TagLabelId;

interface TagLabelRepository
{
    public function save(TagLabel $tagLabel): void;

    public function find(TagLabelId $tagLabelId): ?TagLabel;

    public function findBy(array $criteria, array $opts): TagLabelCollection;

    public function findAll(): TagLabelCollection;
}