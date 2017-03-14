<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chat
 *
 * @ORM\Table(name="chat")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ChatRepository")
 */
class Chat
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
	 * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $user;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="message", type="text")
	 */
	private $message;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="sent_time", type="datetime")
	 */
	private $sentTime;

	public $ilYA;

	public function __construct()
	{
		$this->sentTime = new \DateTime();
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
	 * Set user
	 *
	 * @return Chat
	 */
	public function setUser(\UserBundle\Entity\User $user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Set message
	 *
	 * @param string $message
	 *
	 * @return Chat
	 */
	public function setMessage($message)
	{
		$this->message = $message;

		return $this;
	}

	/**
	 * Get message
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * Set sentTime
	 *
	 * @param \DateTime $sentTime
	 *
	 * @return Chat
	 */
	public function setSentTime($sentTime)
	{
		$this->sentTime = $sentTime;

		return $this;
	}

	/**
	 * Get sentTime
	 *
	 * @return \DateTime
	 */
	public function getSentTime()
	{
		return $this->sentTime;
	}
}
