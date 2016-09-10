<?php

namespace CoreBundle\FormModels;

use Symfony\Component\Validator\Constraints as Assert;

class ContactModel
{
	/**
	 * @Assert\Length(min=3, minMessage="Doit faire au moins {{ limit }} caractères")
	 */
	private $nom;

	/**
	 * @Assert\Length(min=3, minMessage="Doit faire au moins {{ limit }} caractères")
	 */
	private $prenom;

	/**
	 * @Assert\Email(checkMX=true, message="Veuillez entrer une adresse e-mail existante")
	 */
	private $email;

	/**
	 * @Assert\Length(max=255, min=3, maxMessage="Doit faire au plus {{ limit }} caractères", minMessage="Doit faire au moins {{ limit }} caractères")
	 */
	private $objet;

	/**
	 * @Assert\Length(min=10, minMessage="Doit faire au moins {{ limit }} caractères")
	 */
	private $contenu;


	public function getNom()
	{
		return $this->nom;
	}
	public function setNom($nom)
	{
		$this->nom = $nom;
		return $this;
	}

	public function getPrenom()
	{
		return $this->prenom;
	}
	public function setPrenom($prenom)
	{
		$this->prenom = $prenom;
		return $this;
	}

	public function getEmail()
	{
		return $this->email;
	}
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

	public function getObjet()
	{
		return $this->objet;
	}
	public function setObjet($objet)
	{
		$this->objet = $objet;
		return $this;
	}

	public function getContenu()
	{
		return $this->contenu;
	}
	public function setContenu($contenu)
	{
		$this->contenu = $contenu;
		return $this;
	}
}