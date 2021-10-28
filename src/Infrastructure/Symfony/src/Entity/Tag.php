<?php

namespace XTags\App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use XTags\App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Vocabulary::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $vocabulary;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;
    
    /**
     * @ORM\Column(type="string", length=10)
     */
    private $version;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class, inversedBy="tags")
     * @ORM\JoinColumn(nullable=false)
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity=Definition::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $definition;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->labels = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    public function getDefinition(): ?Definition
    {
        return $this->definition;
    }

    public function setDefinition(?Definition $definition): self
    {
        $this->definition = $definition;

        return $this;
    }
}
