<?php

namespace ResponsabilitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Objets de l'inventaire.
 * 
 * @ORM\Table(name="objet")
 * @ORM\Entity(repositoryClass="ResponsabilitesBundle\Repository\ObjetRepository")
 */
class Objet
{
	/**
	 * @ORM\Column(name="id", type="integer")
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
	 * @ORM\ManyToOne(targetEntity="ResponsabilitesBundle\Entity\TypeObjet", inversedBy="objets")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\Length(max=255)
	 * @Assert\NotBlank()
	 * @Assert\Type("string")
	 */
	private $type;
	
	/**
	 * @ORM\Column(type="text")
	 * @Assert\Type("string")
	 */
	private $caracteristiques;


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

	public function getType()
	{
		return $this->type;
	}
	public function setType($type)
	{
		$type->addObjet($this);
		$this->type = $type;
		return $this;
	}

	public function getCaracteristiques()
	{
		return $this->caracteristiques;
	}
	public function setCaracteristiques($caracteristiques)
	{
		$this->caracteristiques = $caracteristiques;
		return $this;
	}
}
