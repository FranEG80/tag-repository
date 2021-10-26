<?php
declare(strict_types=1);

namespace XTags\App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use XTags\App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use XTags\Shared\Domain\Model\ValueObject\Uuid;

/**
 * @ORM\Entity(repositoryClass=TagsRepository::class)
 */
class Tags
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $customName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tag_label_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $version;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity=Vocabularies::class, inversedBy="tags")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vocabulary;

    /**
     * @ORM\ManyToOne(targetEntity=Types::class)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=TagLabel::class, mappedBy="tags", orphanRemoval=true)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=ResourceTags::class, mappedBy="tags", orphanRemoval=true)
     */
    private $resource;

    /**
     * @ORM\ManyToMany(targetEntity=TagLabel::class)
     */
    private $definition;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->label = new ArrayCollection();
        $this->resource = new ArrayCollection();
        $this->definition = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTagLabelId(): ?string
    {
        return $this->tag_label_id;
    }

    public function setTagName(string $tag_label_id): self
    {
        $this->tag_label_id = $tag_label_id;

        return $this;
    }

    public function getDefinition(): Collection
    {
        return $this->definition;
    }

    public function setDefinitionId(string $definition): self
    {
        $this->definition = $definition;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }


    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getVocabulary(): ?Vocabularies
    {
        return $this->vocabulary;
    }

    public function setVocabulary(?Vocabularies $vocabulary): self
    {
        $this->vocabulary = $vocabulary;

        return $this;
    }

    public function getType(): ?Types
    {
        return $this->type;
    }

    public function setType(?Types $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|TagLabel[]
     */
    public function getLabel(): Collection
    {
        return $this->label;
    }

    public function addLabel(TagLabel $label): self
    {
        if (!$this->label->contains($label)) {
            $this->label[] = $label;
            $label->setTags($this);
        }

        return $this;
    }

    public function removeLabel(TagLabel $label): self
    {
        if ($this->label->removeElement($label)) {
            // set the owning side to null (unless already changed)
            if ($label->getTags() === $this) {
                $label->setTags(null);
            }
        }

        return $this;
    }

    public function getCustomName(): ?string
    {
        return $this->customName;
    }

    public function setCustomName(?string $customName): self
    {
        $this->customName = $customName;

        return $this;
    }

    /**
     * @return Collection|ResourceTags[]
     */
    public function getResource(): Collection
    {
        return $this->resource;
    }

    public function addResource(ResourceTags $resource): self
    {
        if (!$this->resource->contains($resource)) {
            $this->resource[] = $resource;
            $resource->setTags($this);
        }

        return $this;
    }

    public function removeResource(ResourceTags $resource): self
    {
        if ($this->resource->removeElement($resource)) {
            // set the owning side to null (unless already changed)
            if ($resource->getTags() === $this) {
                $resource->setTags(null);
            }
        }

        return $this;
    }

    public function addDefinitionId(TagLabel $definitionId): self
    {
        if (!$this->definition->contains($definitionId)) {
            $this->definition[] = $definitionId;
        }

        return $this;
    }

    public function removeDefinitionId(TagLabel $definitionId): self
    {
        $this->definition->removeElement($definitionId);

        return $this;
    }

}
