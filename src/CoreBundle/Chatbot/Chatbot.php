<?php

namespace ResponsabilitesBundle\Chatbot;

class Chatbot
{
	private $em;
	private $chatRepository;
	
	public function _construct($entityManager, $chatRepositoryName)
	{
		$this->em = $entityManager;
		$this->chatRepository = $this->em->getRepository($chatRepositoryName);
	}
}
