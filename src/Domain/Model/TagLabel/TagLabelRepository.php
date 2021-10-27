<?php
declare(strict_types=1); 

namespace XTags\Domain\Model\TagLabel;

use XTags\Domain\Model\TagLabel\ValueObject\LabelId;

interface TagLabelRepository
{
    public function save(TagLabel $tagLabel): void;

    public function find(LabelId $tagLabelId): ?TagLabel;

    public function findBy(array $criteria, array $opts): TagLabelCollection;

    public function findAll(): TagLabelCollection;
}