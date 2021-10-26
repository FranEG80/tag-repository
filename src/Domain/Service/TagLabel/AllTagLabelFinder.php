<?php
declare(strict_types=1);

namespace XTags\Domain\Service\TagLabel;

use XTags\Domain\Model\TagLabel\TagLabel;
use XTags\Domain\Model\TagLabel\TagLabelCollection;
use XTags\Domain\Model\TagLabel\TagLabelRepository;
use XTags\Domain\Model\TagLabel\Exception\TagLabelDoesNotExistException;
use XTags\Infrastructure\Exceptions\Api\TagLabelResources;

class AllTagLabelFinder
{
    private TagLabelRepository $tagLabelRepository;

    public function __construct(TagLabelRepository $tagLabelRepository)
    {
        $this->tagLabelRepository = $tagLabelRepository;
    }

    public function __invoke(): TagLabelCollection
    {
        $tagLabel = $this->tagLabelRepository->findAll();

        if (null === $tagLabel) {
            throw new TagLabelDoesNotExistException(TagLabelResources::create());
        }

        return $tagLabel;
    }
}
