<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use CalendR\Event\AbstractEvent;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event extends AbstractEvent
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="begin", type="datetime")
	 * @Assert\DateTime(message="core.event.date_debut.date_time")
	 */
	protected $begin;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="end", type="datetime")
	 * @Assert\DateTime(message="core.event.end.date_time")
	 */
	protected $end;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=255)
	 * @Assert\Length(min=3, max=255, minMessage="core.event.title.length.min", maxMessage="core.event.title.length.max")
	 * @Assert\NotBlank(message="core.event.title.not_blank")
	 */
	protected $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content", type="text", nullable=true)
	 * @Assert\Type(type="string", message="core.event.content.string")
	 */
	protected $content;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="uid", type="string", length=255, unique=true)
	 * @Gedmo\Slug(fields={"title"}, updatable=false)
	 */
	protected $uid;


	public function __construct()
	{
		$this->begin = new \DateTime();
		$this->end   = new \DateTime('@'.(time()+3600*26));
	}

	/**
	 * @Assert\IsTrue(message="La date de fin doit être postérieure à la date de début")
	 */
	public function isEventValid()
	{
		return $this->begin->diff($this->end)->invert == 0;
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
	 * Set uid (a slug)
	 *
	 * @param string $uid
	 *
	 * @return Event
	 */
	public function setUid($uid)
	{
		$this->uid = $uid;

		return $this;
	}

	/**
	 * Get uid (a slug)
	 *
	 * @return string
	 */
	public function getUid()
	{
		return $this->uid;
	}

	/**
	 * Set begin
	 *
	 * @param \DateTime $begin
	 *
	 * @return Event
	 */
	public function setBegin($begin)
	{
		$this->begin = $begin;

		return $this;
	}

	/**
	 * Get begin
	 *
	 * @return \DateTime
	 */
	public function getBegin()
	{
		return $this->begin;
	}

	/**
	 * Set end
	 *
	 * @param \DateTime $end
	 *
	 * @return Event
	 */
	public function setEnd($end)
	{
		$this->end = $end;

		return $this;
	}

	/**
	 * Get end
	 *
	 * @return \DateTime
	 */
	public function getEnd()
	{
		return $this->end;
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
