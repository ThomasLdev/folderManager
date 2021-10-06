<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
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
     * @ORM\OneToMany(targetEntity=Value::class, mappedBy="type")
     */
    private $values;

    /**
     * @ORM\OneToMany(targetEntity=Option::class, mappedBy="type", orphanRemoval=true)
     */
    private $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
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
     * @return Collection|Value[]
     */
    public function getValues(): Collection
    {
        return $this->values;
    }

    public function addValue(Value $value): self
    {
        if (!$this->values->contains($value)) {
            $this->values[] = $value;
            $value->setType($this);
        }

        return $this;
    }

    public function removeValue(Value $value): self
    {
        if ($this->values->removeElement($value)) {
            // set the owning side to null (unless already changed)
            if ($value->getType() === $this) {
                $value->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setType($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getType() === $this) {
                $option->setType(null);
            }
        }

        return $this;
    }
}
