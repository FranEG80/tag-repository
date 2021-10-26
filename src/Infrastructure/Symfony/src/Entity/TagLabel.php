<?php
declare(strict_types=1);

namespace XTags\App\Entity;

use Doctrine\ORM\Mapping as ORM;
use XTags\App\Repository\TagLabelRepository;

/**
 * @ORM\Entity(repositoryClass=TagLabelRepository::class)
 */
class TagLabel
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
     * @ORM\Column(type="integer")
     */
    private $version;

    /**
     * @ORM\ManyToOne(targetEntity=Languages::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Lang;

    /**
     * @ORM\ManyToOne(targetEntity=Tags::class, inversedBy="label")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tags;

    public function __construct()
    {        
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

    /**
     * Get the value of version
     */ 
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the value of version
     *
     * @return  self
     */ 
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getLang(): ?Languages
    {
        return $this->Lang;
    }

    public function setLang(?Languages $Lang): self
    {
        $this->Lang = $Lang;

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
