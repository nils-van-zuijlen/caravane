<?php
namespace CoreBundle\Mailer;

class ContactEmail implements EmailInterface
{
	private $subject;
	private $body;
	private $email;
	private $nom;
	private $prenom;


	public function getType()
	{
		return "contact";
	}

	public function getSubject()
	{
		return $this->subject;
	}
	public function setSubject($subject)
	{
		$this->subject = $subject;
		return $this;
	}

	public function getBody()
	{
		return $this->body;
	}
	public function setBody($body)
	{
		$this->body = $body;
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

	public function getTo()
	{
		return array(
			"to" => array(
				"contact"
				),
			);
	}

	public function getFrom()
	{
		return array(
			$this->getDisplay() => $this->getEmail(),
			);
	}

	public function getDisplay()
	{
		return $this->getPrenom()." ".$this->getNom();
	}
}
