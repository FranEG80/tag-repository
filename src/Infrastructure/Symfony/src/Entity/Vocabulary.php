<?php

namespace XTags\App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use XTags\App\Repository\VocabularyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VocabularyRepository::class)
 */
class Vocabulary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $search_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $definition_url;

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
     * @ORM\OneToMany(targetEntity=Schema::class, mappedBy="vocabulary", orphanRemoval=true)
     */
    private $semantic_schemas;

    public function __construct()
    {
        $this->semantic_schemas = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getSearchUrl(): ?string
    {
        return $this->search_url;
    }

    public function setSearchUrl(string $search_url): self
    {
        $this->search_url = $search_url;

        return $this;
    }

    public function getDefinitionUrl(): ?string
    {
        return $this->definition_url;
    }

    public function setDefinitionUrl(string $definition_url): self
    {
        $this->definition_url = $definition_url;

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

    /**
     * @return Collection|Schema[]
     */
    public function getSemanticSchemas(): Collection
    {
        return $this->semantic_schemas;
    }

    public function addSemanticSchema(Schema $semanticSchema): self
    {
        if (!$this->semantic_schemas->contains($semanticSchema)) {
            $this->semantic_schemas[] = $semanticSchema;
            $semanticSchema->setVocabulary($this);
        }

        return $this;
    }

    public function removeSemanticSchema(Schema $semanticSchema): self
    {
        if ($this->semantic_schemas->removeElement($semanticSchema)) {
            // set the owning side to null (unless already changed)
            if ($semanticSchema->getVocabulary() === $this) {
                $semanticSchema->setVocabulary(null);
            }
        }

        return $this;
    }
}
