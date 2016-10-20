<?php

namespace CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use CoreBundle\Entity\Actu;

class NewActuEvent extends BaseEvent
{
	protected $newActu;
	protected $user

	function __construct(Actu $newActu, UserInterface $user)
	{
		$this->newActu = $newActu;
		$this->user    = $user;
	}

	public function getActu()
	{
		return $this->newActu;
	}

	public function getUser()
	{
		return $this->user;
	}
}
