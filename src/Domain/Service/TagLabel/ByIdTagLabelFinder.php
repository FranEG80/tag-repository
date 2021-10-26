<?php
declare(strict_types=1);

namespace XTags\Domain\Service\TagLabel;

use XTags\Domain\Model\TagLabel\TagLabel;
use XTags\Domain\Model\TagLabel\TagLabelRepository;
use XTags\Domain\Model\TagLabel\Exception\TagLabelDoesNotExistException;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelId;
use XTags\Infrastructure\Exceptions\Api\TagLabelResources;

class ByIdTagLabelFinder
{
    private TagLabelRepository $tagLabelRepository;

    public function __construct(TagLabelRepository $tagLabelRepository)
    {
        $this->tagLabelRepository = $tagLabelRepository;
    }

    public function __invoke(TagLabelId $tagLabelId): TagLabel
    {
        $tagLabel = $this->tagLabelRepository->find($tagLabelId);

        if (null === $tagLabel) {
            throw new TagLabelDoesNotExistException(TagLabelResources::create());
        }

        return $tagLabel;
    }
}
