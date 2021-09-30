<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
     * @ORM\ManyToMany(targetEntity=Sku::class, mappedBy="options")
     */
    private $sku;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="options")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Value::class, inversedBy="options")
     * @ORM\JoinColumn(nullable=false)
     */
    private $value;

    public function __construct()
    {
        $this->sku = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function __toString()
    {
        return $this->type . ' ' . $this->value;
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

    public function getValue(): ?Value
    {
        return $this->value;
    }

    public function setValue(?Value $value): self
    {
        $this->value = $value;

        return $this;
    }
}
