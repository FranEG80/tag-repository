<?php
declare(strict_types=1);

namespace XTags\App\Entity;

use Doctrine\ORM\Mapping as ORM;
use XTags\App\Repository\ResourceTagsRepository;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;

/**
 * @ORM\Entity(repositoryClass=ResourceTagsRepository::class)
 */
class ResourceTags
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="uuid", unique=true)
     */
    private $resource_id;

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
     * @ORM\ManyToOne(targetEntity=Tags::class, inversedBy="resource")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tags;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId():Uuid
    {
        return $this->id;
    }

    public function getResourceId(): ?Uuid
    {
        return $this->resource_id;
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

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion($version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getTags(): ?Tags
    {
        return $this->tags;
    }

    public function setTags(?Tags $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

}