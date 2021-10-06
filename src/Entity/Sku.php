<?php

namespace App\Entity;

use App\Repository\SkuRepository;
use App\Entity\NorlogFolder;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkuRepository::class)
 * @ORM\Table(name="sku")
 * @UniqueEntity("SKU")
 */
class Sku
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
    private ?string $SKU;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $picture_1 = '';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $picture_2 = '';

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $exported;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="skus", cascade={"persist"})
     */
    private $options;

    /**
     * @ORM\ManyToOne(targetEntity=NorlogFolder::class, inversedBy="skus")
     */
    private ?NorlogFolder $folder;

    public function __construct()
    {
        $this->options = new ArrayCollection();
//        $this->folders = new ArrayCollection();
        $this->exported = false;
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSKU(): ?string
    {
        return $this->SKU;
    }

    public function setSKU(string $SKU): self
    {
        $this->SKU = $SKU;

        return $this;
    }

    public function getPicture1(): ?string
    {
        return $this->picture_1;
    }

    public function setPicture1(string $picture_1): self
    {
        $this->picture_1 = $picture_1;

        return $this;
    }

    public function getPicture2(): ?string
    {
        return $this->picture_2;
    }

    public function setPicture2(string $picture_2): self
    {
        $this->picture_2 = $picture_2;

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

    public function getExported(): ?bool
    {
        return $this->exported;
    }

    public function setExported(bool $exported): self
    {
        $this->exported = $exported;

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
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }

    public function getFolder(): ?NorlogFolder
    {
        return $this->folder;
    }

    public function setFolder(?NorlogFolder $folder): self
    {
        $this->folder = $folder;

        return $this;
    }
}
