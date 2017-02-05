<?php
namespace CoreBundle\Mailer;

class ContactEmail implements EmailInterface
{
	/**
	 * @Assert\Length(max=255, min=3, maxMessage="core.contact.objet.length.max", minMessage="core.contact.objet.length.min")
	 */
	private $subject;

	/**
	 * @Assert\Length(min=10, minMessage="core.contact.contenu.length.min")
	 */
	private $body;

	/**
	 * @Assert\Email(checkMX=true, message="core.contact.email.email")
	 */
	private $email;

	/**
	 * @Assert\Length(min=3, minMessage="core.contact.nom.length.min")
	 */
	private $nom;

	/**
	 * @Assert\Length(min=3, minMessage="core.contact.prenom.length.min")
	 */
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
