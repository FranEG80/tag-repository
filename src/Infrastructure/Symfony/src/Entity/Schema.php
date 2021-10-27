<?php

namespace XTags\App\Entity;

use XTags\App\Repository\SchemaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SchemaRepository::class)
 * @ORM\Table(name="`schema`")
 */
class Schema
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Vocabulary::class, inversedBy="semantic_schemas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vocabulary;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $schema_url;

    /**
     * @ORM\Column(type="json")
     */
    private $relations_parse = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVocabulary(): ?Vocabulary
    {
        return $this->vocabulary;
    }

    public function setVocabulary(?Vocabulary $vocabulary): self
    {
        $this->vocabulary = $vocabulary;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSchemaUrl(): ?string
    {
        return $this->schema_url;
    }

    public function setSchemaUrl(string $schema_url): self
    {
        $this->schema_url = $schema_url;

        return $this;
    }

    public function getRelationsParse(): ?array
    {
        return $this->relations_parse;
    }

    public function setRelationsParse(array $relations_parse): self
    {
        $this->relations_parse = $relations_parse;

        return $this;
    }
}
