<?php
declare(strict_types=1);

namespace XTags\App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use XTags\App\Repository\VocabulariesRepository;

/**
 * @ORM\Entity(repositoryClass=VocabulariesRepository::class)
 */
class Vocabularies
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
    private $url_vocabulary;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_definitions;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updateAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url_search;

    /**
     * @ORM\OneToMany(targetEntity=Tags::class, mappedBy="vocabulary")
     */
    private $tags;
    
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

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

    public function getUrlVocabulary(): ?string
    {
        return $this->url_vocabulary;
    }

    public function setUrlVocabulary(string $url_vocabulary): self
    {
        $this->url_vocabulary = $url_vocabulary;

        return $this;
    }

    public function getUrlDefinitions(): ?string
    {
        return $this->url_definitions;
    }

    public function setUrlDefinitions(string $url_definitions): self
    {
        $this->url_definitions = $url_definitions;

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

    public function getUrlSearch(): ?string
    {
        return $this->url_search;
    }

    public function setUrlSearch(?string $url_search): self
    {
        $this->url_search = $url_search;

        return $this;
    }

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setVocabulary($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getVocabulary() === $this) {
                $tag->setVocabulary(null);
            }
        }

        return $this;
    }

}
