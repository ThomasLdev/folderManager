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
	private int $id;

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
	 * @ORM\ManyToOne(targetEntity=NorlogFolder::class, inversedBy="skus")
	 */
	private ?NorlogFolder $folder;

	/**
	 * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="skus")
	 */
	private ?Marque $marque;

	/**
	 * @ORM\ManyToOne(targetEntity=Taille::class, inversedBy="skus")
	 */
	private ?Taille $taille;

	/**
	 * @ORM\ManyToOne(targetEntity=Composition::class, inversedBy="skus")
	 */
	private ?Composition $composition;

	/**
	 * @ORM\ManyToOne(targetEntity=Couleur::class, inversedBy="skus")
	 */
	private ?Couleur $couleur;

	/**
	 * @ORM\ManyToOne(targetEntity=Designation::class, inversedBy="skus")
	 */
	private ?Designation $designation;

	/**
	 * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="skus")
	 */
	private ?Etat $etat;

	public function __construct()
	{
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

	public function getFolder(): ?NorlogFolder
	{
		return $this->folder;
	}

	public function setFolder(?NorlogFolder $folder): self
	{
		$this->folder = $folder;

		return $this;
	}

	public function getMarque(): ?Marque
	{
		return $this->marque;
	}

	public function setMarque(?Marque $marque): self
	{
		$this->marque = $marque;

		return $this;
	}

	public function getTaille(): ?Taille
	{
		return $this->taille;
	}

	public function setTaille(?Taille $taille): self
	{
		$this->taille = $taille;

		return $this;
	}

	public function getComposition(): ?Composition
	{
		return $this->composition;
	}

	public function setComposition(?Composition $composition): self
	{
		$this->composition = $composition;

		return $this;
	}

	public function getCouleur(): ?Couleur
	{
		return $this->couleur;
	}

	public function setCouleur(?Couleur $couleur): self
	{
		$this->couleur = $couleur;

		return $this;
	}

	public function getDesignation(): ?Designation
	{
		return $this->designation;
	}

	public function setDesignation(?Designation $designation): self
	{
		$this->designation = $designation;

		return $this;
	}

	public function getEtat(): ?Etat
	{
		return $this->etat;
	}

	public function setEtat(?Etat $etat): self
	{
		$this->etat = $etat;

		return $this;
	}

	public function __toString()
	{
		return $this->getSKU();
	}
}