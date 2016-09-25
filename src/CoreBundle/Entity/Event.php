<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event
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
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_debut", type="datetime")
	 * @Assert\DateTime
	 */
	private $dateDebut;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_fin", type="datetime")
	 * @Assert\DateTime
	 */
	private $dateFin;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=255)
	 * @Assert\Length(min=3, max=255)
	 * @Assert\NotBlank()
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content", type="text", nullable=true)
	 * @Assert\Type("string")
	 */
	private $content;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="slug", type="string", length=255, unique=true)
	 * @Gedmo\Slug(fields={"title"})
	 */
	private $slug;


	function __construct()
	{
		$this->dateDebut = new \DateTime();
		$this->dateFin   = new \DateTime('@'.(time()+3600*26));
	}

	/**
	 * @Assert\IsTrue(message="La date de fin doit être postérieure à la date de début")
	 */
	public function isEventValid()
	{
		return $this->dateDebut->diff($this->dateFin)->invert == 0;
	}

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
	 * Set title
	 *
	 * @param string $title
	 *
	 * @return Event
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set content
	 *
	 * @param string $content
	 *
	 * @return Event
	 */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Set slug
	 *
	 * @param string $slug
	 *
	 * @return Event
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
	 * Set dateDebut
	 *
	 * @param \DateTime $dateDebut
	 *
	 * @return Event
	 */
	public function setDateDebut($dateDebut)
	{
		$this->dateDebut = $dateDebut;

		return $this;
	}

	/**
	 * Get dateDebut
	 *
	 * @return \DateTime
	 */
	public function getDateDebut()
	{
		return $this->dateDebut;
	}

	/**
	 * Set dateFin
	 *
	 * @param \DateTime $dateFin
	 *
	 * @return Event
	 */
	public function setDateFin($dateFin)
	{
		$this->dateFin = $dateFin;

		return $this;
	}

	/**
	 * Get dateFin
	 *
	 * @return \DateTime
	 */
	public function getDateFin()
	{
		return $this->dateFin;
	}

	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preEdit()
	{
		if (!$this->content)
			$this->content = ' ';
	}
}
