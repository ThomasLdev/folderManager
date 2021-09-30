<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 * @UniqueEntity("type")
 * @UniqueEntity("value")
 */
class Option
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
    private ?string $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $value;

    /**
     * @ORM\ManyToMany(targetEntity=Sku::class, mappedBy="options")
     */
    private $sku;

    public function __construct()
    {
        $this->sku = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection|Sku[]
     */
    public function getSku(): Collection
    {
        return $this->sku;
    }

    public function addSku(Sku $sku): self
    {
        if (!$this->sku->contains($sku)) {
            $this->sku[] = $sku;
            $sku->addOption($this);
        }

        return $this;
    }

    public function removeFolder(Sku $sku): self
    {
        if ($this->sku->removeElement($sku)) {
            $sku->removeOption($this);
        }

        return $this;
    }
}
