<?php

namespace ResponsabilitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="ResponsabilitesBundle\Repository\MenuRepository")
 */
class Menu
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="titre", type="string", length=255)
	 * @Assert\Length(max=255, maxMessage="responsabilites.menu.titre.length.max")
	 * @Assert\NotBlank(message="responsabilites.menu.titre.not_blank")
	 */
	private $titre;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="slug", type="string", length=255, unique=true)
	 * @Gedmo\Slug(fields={"titre"}, updatable=false)
	 */
	private $slug;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="datetime")
	 * @Assert\DateTime(message="responsabilites.menu.date.date_time")
	 * @Assert\NotBlank(message="responsabilites.menu.date.not_blank")
	 */
	private $date;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="entree", type="text", nullable=true)
	 */
	private $entree;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="plat", type="text", nullable=true)
	 */
	private $plat;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="dessert", type="text")
	 */
	private $dessert;


	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set titre
	 *
	 * @param string $titre
	 *
	 * @return Menu
	 */
	public function setTitre($titre)
	{
		$this->titre = $titre;

		return $this;
	}

	/**
	 * Get titre
	 *
	 * @return string
	 */
	public function getTitre()
	{
		return $this->titre;
	}

	/**
	 * Set slug
	 *
	 * @param string $slug
	 *
	 * @return Menu
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * Get slug
	 *
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * Set date
	 *
	 * @param \DateTime $date
	 *
	 * @return Menu
	 */
	public function setDate($date)
	{
		$this->date = $date;

		return $this;
	}

	/**
	 * Get date
	 *
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Set entree
	 *
	 * @param string $entree
	 *
	 * @return Menu
	 */
	public function setEntree($entree)
	{
		$this->entree = $entree;

		return $this;
	}

	/**
	 * Get entree
	 *
	 * @return string
	 */
	public function getEntree()
	{
		return $this->entree;
	}

	/**
	 * Set plat
	 *
	 * @param string $plat
	 *
	 * @return Menu
	 */
	public function setPlat($plat)
	{
		$this->plat = $plat;

		return $this;
	}

	/**
	 * Get plat
	 *
	 * @return string
	 */
	public function getPlat()
	{
		return $this->plat;
	}

	/**
	 * Set dessert
	 *
	 * @param string $dessert
	 *
	 * @return Menu
	 */
	public function setDessert($dessert)
	{
		$this->dessert = $dessert;

		return $this;
	}

	/**
	 * Get dessert
	 *
	 * @return string
	 */
	public function getDessert()
	{
		return $this->dessert;
	}
}
