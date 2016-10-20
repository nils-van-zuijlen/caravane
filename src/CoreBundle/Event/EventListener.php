<?php

namespace CoreBundle\Event;

use CoreBundle\Chatbot\Chatbot;

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
}