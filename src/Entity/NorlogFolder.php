<?php

namespace App\Entity;

use App\Repository\NorlogFolderRepository;
use App\Entity\Sku;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NorlogFolderRepository::class)
 * @ORM\Table(name="norlog_folder")
 */
class NorlogFolder
{
    public function __construct()
    {
        $this->skus = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many Folders can have Many Skus
     * @ORM\ManyToMany(targetEntity=Sku::class, mappedBy="folders")
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getSkus(): ArrayCollection
    {
        return $this->skus;
    }

    /**
     * @param Sku $sku
     */
    public function addSku(Sku $sku): void
    {
        if (!$this->skus->contains($sku)) {
            $this->skus[] = $sku;
        }
    }

    public function removeSku(Sku $sku): self
    {
        $this->skus->removeElement($sku);

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
