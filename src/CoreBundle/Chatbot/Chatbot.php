<?php

namespace CoreBundle\Chatbot;

use CoreBundle\Entity\Chat;

class Chatbot
{
	private $em;
	private $tokenStorage;
	private $authChecker;
	private $parameters;
	private $chatRepository = null;
	private $userRepository = null;
	private $actualUser = null;
	private $chatbotUser = null;
	
	public function __construct($entityManager, $tokenStorage, $authChecker, array $parameters)
	{
		$this->em             = $entityManager;
		$this->tokenStorage   = $tokenStorage;
		$this->authChecker    = $authChecker;
		$this->parameters     = $parameters;
	}

	public function getChatRepository()
	{
		if ($this->chatRepository !== null)
			return $this->chatRepository;
		$this->chatRepository = $this->em->getRepository($parameters['repositoryName']['chat']);
		return $this->chatRepository;
	}

	public function getUserRepository()
	{
		if ($this->userRepository !== null)
			return $this->userRepository;
		$this->userRepository = $this->em->getRepository($parameters['repositoryName']['user']);
		return $this->userRepository;
	}

	public function getActualUser()
	{
		if ($this->actualUser !== null)
			return $this->actualUser;
		$this->actualUser = $this->tokenStorage->getToken()->getUser();
		return $this->actualUser;
	}

	public function getChatbotUser()
	{
		if ($this->chatbotUser !== null)
			return $this->chatbotUser;
		$this->chatbotUser = $this
			->getUserRepository()
			->findOneByUsername($parameters['chatbotUsername']);
		return $this->chatbotUser;
	}

	/**
	 * Check if user is an admin
	 * And then check whether there are an admin function in the message
	 * 
	 * @param  Chat   $chat The original message
	 * @return Chat         The modified (or not) message
	 */
	public function checkAdminFunctions(Chat $chat)
	{
		$message = $chat->getMessage();
		$user    = $chat->getUser();
		$edited  = false;

		if ($this->authChecker->isGranted($this->parameters['role_admin'])) {
			#effacer tout le chat en laissant un message (ou pas)
			if (preg_match("#^@erase_all#", $message)) {
				$message = preg_replace("#@erase_all(.*)#", "[b]Chat effacé[/b]$1", $message);
				$this->getChatRepository()->eraseAll();
				$edited = true;
			#utiliser un autre utilisateur quelconque
			} else if (preg_match("#^@user\[.+\] .+#U", $message)) {
				$username = preg_replace("#@user\[(.+)\] .+#", "$1", $message);
				$user2 = $this->getUserRepository()->findOneByUsername($username);
				$message = preg_replace("#@user\[.+\] (.+)#", "$1", $message);
				if ($user2 != null) {
					$user = $user2;
					$edited = true;
				}
			#utiliser le chatbot pour s'exprimer
			} else if (preg_match("#^@chatbot#", $message)) {
				$user = $this->getChatbotUser();
				$message = preg_replace("#@chatbot (.+)#", "$1", $message);
				$edited = true;
			}

			if ($edited) {
				$chat
					->setUser($user)
					->setMessage($message);
			}
		}

		return $chat;
	}

	/**
	 * Checks if a message contains some easter-eggs,
	 * create chatbot response and persist it.
	 * Does not work if message is sent by the chatbot.
	 * 
	 * @param  Chat   $chat Message to check for
	 * @return void
	 */
	public function checkEasterEggs(Chat $chat)
	{
		$user    = $chat->getUser();
		$message = $chat->getMessage();

		if ($user !== $this->getChatbotUser()) {
			$eggs = array(
					'You\'re up' => 'Yes, We\'re Up!',
					'Caravane'   => 'La Caravane prend le départ...',
					'chatbot'    => 'Oui, c\'est moi.',
					'nils'       => 'On parle de celui qui m\'a créé?',
					'bonjour'    => 'Bonjour sujet de test n°'.$user->getId(),
				);

			foreach ($eggs as $key => $value) {
				if (preg_match('#'.preg_quote($key).'#i', $message)) {
					$egg = new Chat();
					$egg
						->setUser($this->getChatbotUser())
						->setMessage($value);
					$this->em->persist($egg);
				}
			}
		}
	}
}