<?php

namespace CoreBundle\Event;

use CoreBundle\Chatbot\Chatbot;
use FOS\UserBundle\Event\FormEvent;

class EventListener
{
	protected $chatbot;

	public function __construct(Chatbot $chatbot)
	{
		$this->chatbot = $chatbot;
	}

	public function newActu(NewActuEvent $event)
	{
		$this->chatbot->newActuNotification($event->getActu(), $event->getUser());
		return $event;
	}

	public function newUser(FormEvent $event)
	{
		$user = $event->getForm()->getNormData();
		$this->chatbot->newUserNotification($user);
		return $event;
	}
}
