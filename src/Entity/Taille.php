<?php

namespace App\Entity;

use App\Repository\TailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TailleRepository::class)
 * @UniqueEntity("name")
 */
class Taille
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
     * @ORM\OneToMany(targetEntity=Sku::class, mappedBy="taille")
     */
    private $skus;

    public function __construct()
    {
        $this->skus = new ArrayCollection();
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
     * @return Collection|Sku[]
     */
    public function getSkus(): Collection
    {
        return $this->skus;
    }

    public function addSku(Sku $sku): self
    {
        if (!$this->skus->contains($sku)) {
            $this->skus[] = $sku;
            $sku->setTaille($this);
        }

        return $this;
    }

    public function removeSku(Sku $sku): self
    {
        if ($this->skus->removeElement($sku)) {
            // set the owning side to null (unless already changed)
            if ($sku->getTaille() === $this) {
                $sku->setTaille(null);
            }
        }

        return $this;
    }
}
