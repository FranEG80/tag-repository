<?php
declare(strict_types=1);

namespace XTags\Domain\Service\TagLabel;

use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Domain\Model\TagLabel\Exception\TagLabelAlreadyExistException;
use XTags\Domain\Model\TagLabel\TagLabel;
use XTags\Domain\Model\TagLabel\TagLabelRepository;
use XTags\Domain\Model\TagLabel\ValueObject\LabelName;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
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
        LabelName $labelName = null,
        Version $version = null
    ): TagLabel
    {
        $tagLabels = $this->checkIfExist($languageId, $vocabulariesId, $version);
        
        if (count($tagLabels) > 0) return $tagLabels; 
        // $this->assertTagDoesNotExists($tagLabels);

        $tag = TagLabel::create( $labelName, $languageId, $vocabulariesId );

        $this->repository->save($tag);

        return $tag;
        
    }

    public function assertTagDoesNotExists($tagLabels): void
    {
        if (count($tagLabels) > 0) {
            throw new TagLabelAlreadyExistException(TagLabelResources::create(), null);
        }
    }

    public function checkIfExist( $languagesId, $vocabulariesId, $version)
    {

        $tagLabels = $this->repository->findBy(
            [
                'language' => $languagesId ? $languagesId->value() : null,
                'version' => $version ? $version->value() : TagLabel::CURRENT_VERSION_TAG_LABEL,
                'vocabulary' => $vocabulariesId ? $vocabulariesId->value() : null
            ],
            ['name' => 'ASC']
        );
        return $tagLabels;
    }
    
}
