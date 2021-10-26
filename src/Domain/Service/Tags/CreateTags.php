<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Tags;

use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\TagLabel\ValueObject\TagLabelId;
use XTags\Domain\Model\TagLabel\ValueObject\TagName;
use XTags\Domain\Model\Tags\Exception\TagsAlreadyExistException;
use XTags\Domain\Model\Tags\Tags;
use XTags\Domain\Model\Tags\TagsRepository;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Exceptions\Api\TagsResource;
use XTags\Shared\Domain\Model\ValueObject\DateTimeInmutable;

class CreateTags
{
    protected TagsRepository $repository;

    public function __construct(TagsRepository $repository )
    {
        $this->repository = $repository;
    }

    public function __invoke(
        TagId $tagId,
        TagName $custonName,
        TagLabelId $tagLabelId,
        ResourceTagId $resourceTagId,
        VocabulariesId $vocabulariesId,
        TypesId $typesId
    ): Tags
    {
        $this->assertTagDoesNotExists($tagId);

        $tag = Tags::create( $tagId, $custonName, $tagLabelId, $resourceTagId, $vocabulariesId, $typesId );

        $this->repository->save($tag);

        return $tag;
        
    }

    public function assertTagDoesNotExists(TagId $tagId): void
    {
        if (null !== $this->repository->find($tagId)) {
            throw new TagsAlreadyExistException(TagsResource::create(), null);
        }
    }

}
