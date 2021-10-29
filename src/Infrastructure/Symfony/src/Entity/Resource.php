<?php

namespace XTags\App\Entity;

use XTags\App\Repository\ResourceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ResourceRepository::class)
 */
class Resource
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\OneToOne(targetEntity=Resource::class, mappedBy="resource")
     */
    private $id;

    /**
     * @ORM\Column(type="uuid")
     */
    private $external_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $external_system_id;

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

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getExternalId()
    {
        return $this->external_id;
    }

    public function setExternalId($external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }

    public function getExternalSystemId(): ?int
    {
        return $this->external_system_id;
    }

    public function setExternalSystemId(int $external_system_id): self
    {
        $this->external_system_id = $external_system_id;

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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }
}
