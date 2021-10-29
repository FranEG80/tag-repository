<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Tags;

use XTags\Domain\Model\ResourceTags\ValueObject\ResourceTagId;
use XTags\Domain\Model\Tags\Exception\TagsAlreadyExistException;
use XTags\Domain\Model\Tags\Tags;
use XTags\Domain\Model\Tags\TagsRepository;
use XTags\Domain\Model\ValueObject\DefinitionName;
use XTags\Domain\Model\Tags\ValueObject\TagId;
use XTags\Domain\Model\Tags\ValueObject\TagName;
use XTags\Domain\Model\Types\ValueObject\TypesId;
use XTags\Domain\Model\Vocabularies\ValueObject\VocabulariesId;
use XTags\Infrastructure\Exceptions\Api\TagsResources;

class CreateTags
{
    protected TagsRepository $repository;

    public function __construct(TagsRepository $repository )
    {
        $this->repository = $repository;
    }

    public function __invoke(
        TagName $custonName,
        DefinitionName $definition,
        ResourceTagId $resourceTagId,
        VocabulariesId $vocabulariesId,
        TypesId $typesId
    ): Tags
    {
        if ($definition) $this->assertTagDoesNotExists($definition);

        $tag = Tags::create( $custonName, $definition, $resourceTagId, $vocabulariesId, $typesId );

        $this->repository->save($tag);

        return $tag;
        
    }

    public function assertTagDoesNotExists(DefinitionName $definition): void
    {
        if (count($this->repository->findBy([
            'definition' => $definition
        ])) > 0) {
            throw new TagsAlreadyExistException(TagsResources::create(), null);
        }
    }

}
