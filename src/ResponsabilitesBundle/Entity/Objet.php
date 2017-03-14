<?php

namespace ResponsabilitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
	 * @Assert\Length(max=255, maxMessage="responsabilites.objet.nom.length.max")
	 * @Assert\NotBlank(message="responsabilites.objet.nom.not_blank")
	 * @Assert\Type(type="string", message="responsabilites.objet.nom.string")
	 */
	private $nom;
	
	/**
	 * @ORM\ManyToOne(targetEntity="ResponsabilitesBundle\Entity\TypeObjet", inversedBy="objets", cascade="persist")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $type;
	
	/**
	 * @ORM\Column(type="text")
	 * @Assert\Type(type="string", message="responsabilites.objet.caracteristiques.string")
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
	public function setType(TypeObjet $type)
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
