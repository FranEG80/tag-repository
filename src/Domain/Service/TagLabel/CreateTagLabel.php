<?php
declare(strict_types=1);

namespace XTags\Domain\Service\TagLabel;

use XTags\Domain\Model\Definition\ValueObject\DefinitionId;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\TagLabel\Exception\TagLabelAlreadyExistException;
use XTags\Domain\Model\TagLabel\TagLabel;
use XTags\Domain\Model\TagLabel\TagLabelRepository;
use XTags\Domain\Model\TagLabel\ValueObject\LabelName;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Domain\Model\TagLabel\DoctrineTagLabelRepository;
use XTags\Infrastructure\Exceptions\Api\TagLabelResources;
use XTags\Shared\Domain\Model\ValueObject\Version;

class CreateTagLabel
{
    protected TagLabelRepository $repository;

    public function __construct(TagLabelRepository $repository )
    {
        $this->repository = $repository;
    }

    public function __invoke(
        LanguagesId $languageId,
        VocabulariesId $vocabulariesId, 
        DefinitionId $definitionId,       
        LabelName $labelName,
        Version $version  
    ): TagLabel
    {
        $this->assertTagDoesNotExists($definitionId, $languageId, $vocabulariesId, $version);

        $tag = TagLabel::create( TagId::v4(), $labelName, $languageId, $definitionId, $vocabulariesId );

        $this->repository->save($tag);

        return $tag;
        
    }

    public function assertTagDoesNotExists(DefinitionId $definitionId, LanguagesId $languagesId, VocabulariesId $vocabulariesId, Version $version): void
    {
        $tagLabels = $this->repository->findBy(
            [
                'definitionId' => $definitionId ? $definitionId->value() : null,
                'lang_id' => $languagesId ? $languagesId->value() : null,
                'version' => $version ? $version->value() : TagLabel::CURRENT_VERSION_TAG_LABEL,
                'vocabulary' => $vocabulariesId ? $vocabulariesId->value() : null
            ],
            ['name' => 'ASC']
        );

        if (count($tagLabels) > 0) {
            throw new TagLabelAlreadyExistException(TagLabelResources::create(), null);
        }
    }
}
