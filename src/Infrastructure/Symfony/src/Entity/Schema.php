<?php

namespace XTags\App\Entity;

use XTags\App\Repository\SchemaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SchemaRepository::class)
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
     * @ORM\Column(type="integer")
     **/
    private $vocabulary_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $schema_url;

    /**
     * @ORM\Column(type="text")
     */
    private $relations_parse;


    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getVocabularyId(): ?int
    {
        return $this->vocabulary_id;
    }

    public function setVocabularyId(int $vocabulary_id): self
    {
        $this->vocabulary_id = $vocabulary_id;

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

    public function getRelationsParse(): ?string
    {
        return $this->relations_parse;
    }

    public function setRelationsParse(string $relations_parse): self
    {
        $this->relations_parse = $relations_parse;

        return $this;
    }
}
