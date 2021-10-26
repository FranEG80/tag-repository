<?php
declare(strict_types=1);

namespace XTags\Domain\Service\TagLabel;

use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\TagLabel\Exception\TagLabelAlreadyExistException;
use XTags\Domain\Model\TagLabel\TagLabel;
use XTags\Domain\Model\TagLabel\TagLabelRepository;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelId;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelName;
use XTags\Domain\Model\TagLabel\ValueObject\TagName;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Domain\Model\TagLabel\DoctrineTagLabelRepository;
use XTags\Infrastructure\Exceptions\Api\TagLabelResources;

class CreateTagLabel
{
    protected TagLabelRepository $repository;

    public function __construct(TagLabelRepository $repository )
    {
        $this->repository = $repository;
    }

    public function __invoke(
        TagId $tagId,
        LanguagesId $languageId,
        TagLabelName $name
    ): TagLabel
    {
        $this->assertTagDoesNotExists($tagId, $languageId);

        $tag = TagLabel::create( $tagId, $name, $languageId );

        $this->repository->save($tag);

        return $tag;
        
    }

    public function assertTagDoesNotExists(TagId $tagId, LanguagesId $languagesId): void
    {
        $tagLabels = $this->repository->findBy(
            [
                'tags_id' => $tagId,
                'lang_id' => $languagesId,
                'version' => TagLabel::CURRENT_VERSION_TAG_LABEL
            ],
            ['name' => 'ASC']
        );

        if (count($tagLabels) > 0) {
            throw new TagLabelAlreadyExistException(TagLabelResources::create(), null);
        }
    }
}
