<?php

namespace ResponsabilitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Types d'objets de l'inventaire.
 * 
 * @ORM\Table(name="type_objet")
 * @ORM\Entity(repositoryClass="ResponsabilitesBundle\Repository\TypeObjetRepository")
 */
class TypeObjet
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(max=255)
	 * @Assert\NotBlank()
	 * @Assert\Type("string")
	 */
	private $nom;

	/**
	 * @ORM\OneToMany(targetEntity="ResponsabilitesBundle\Entity\Objet", mappedBy="type")
	 */
	private $objets;

	public function getId()
	{
		return $this->id;
	}
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	public function getNom()
	{
		return $this->nom;
	}
	public function setNom($nom)
	{
		$this->nom = $nom;
		return $this;
	}
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->objets = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Add objet
	 *
	 * @param \ResponsabilitesBundle\Entity\Objet $objet
	 *
	 * @return TypeObjet
	 */
	public function addObjet(\ResponsabilitesBundle\Entity\Objet $objet)
	{
		$this->objets[] = $objet;

		return $this;
	}

	/**
	 * Remove objet
	 *
	 * @param \ResponsabilitesBundle\Entity\Objet $objet
	 */
	public function removeObjet(\ResponsabilitesBundle\Entity\Objet $objet)
	{
		$this->objets->removeElement($objet);
	}

	/**
	 * Get objets
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getObjets()
	{
		return $this->objets;
	}
}