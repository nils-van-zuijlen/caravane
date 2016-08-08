<?php

namespace CoreBundle\FormModels;

class ContactModel
{
	private $nom;
	private $prenom;
	private $email;
	private $objet;
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