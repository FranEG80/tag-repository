<?php

namespace XTags\App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LabelRepository::class)
 */
class Label
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

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
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="labels")
     */
    private $definition_id;

    /**
     * @ORM\ManyToOne(targetEntity=Vocabulary::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $vocabulary;

    public function __construct()
    {
        $this->definition_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
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
     * @return Collection|Tag[]
     */
    public function getDefinitionId(): Collection
    {
        return $this->definition_id;
    }

    public function addDefinitionId(Tag $definitionId): self
    {
        if (!$this->definition_id->contains($definitionId)) {
            $this->definition_id[] = $definitionId;
        }

        return $this;
    }

    public function removeDefinitionId(Tag $definitionId): self
    {
        $this->definition_id->removeElement($definitionId);

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
}
