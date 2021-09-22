<?php

namespace App\Entity;

use App\Repository\NorlogFolderRepository;
use App\Entity\Sku;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NorlogFolderRepository::class)
 * @ORM\Table(name="norlog_folder")
 */
class NorlogFolder
{
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->skus = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * Special ID set by Norlog for each folder
     */
    private ?string $norlogReference;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Sku::class, mappedBy="folder", cascade={"persist"})
     */
    private $skus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNorlogReference(): ?string
    {
        return $this->norlogReference;
    }

    public function setNorlogReference(?string $norlogReference): self
    {
        $this->norlogReference = $norlogReference;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
            $sku->setFolder($this);
        }

        return $this;
    }

    public function removeSku(Sku $sku): self
    {
        if ($this->skus->removeElement($sku)) {
            // set the owning side to null (unless already changed)
            if ($sku->getFolder() === $this) {
                $sku->setFolder(null);
            }
        }

        return $this;
    }
}