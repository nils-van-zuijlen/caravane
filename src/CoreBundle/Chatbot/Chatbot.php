<?php

namespace CoreBundle\Chatbot;

use CoreBundle\Entity\Chat;
use CoreBundle\Entity\Actus;
use UserBundle\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Chatbot
{
	private $em;
	private $tokenStorage;
	private $authChecker;
	private $router;
	private $translator;
	private $parameters;
	private $chatRepository = null;
	private $userRepository = null;
	private $actualUser     = null;
	private $chatbotUser    = null;
	
	public function __construct($entityManager, $tokenStorage, $authChecker, UrlGeneratorInterface $router, $translator, array $parameters)
	{
		$this->em           = $entityManager;
		$this->tokenStorage = $tokenStorage;
		$this->authChecker  = $authChecker;
		$this->router       = $router;
		$this->translator   = $translator;
		$this->parameters   = $parameters;
	}

	public function getChatRepository()
	{
		if ($this->chatRepository !== null)
			return $this->chatRepository;
		$this->chatRepository = $this->em->getRepository($this->parameters['repositoryName']['chat']);
		return $this->chatRepository;
	}

	public function getUserRepository()
	{
		if ($this->userRepository !== null)
			return $this->userRepository;
		$this->userRepository = $this->em->getRepository($this->parameters['repositoryName']['user']);
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
			->findOneByUsername($this->parameters['chatbotUsername']);
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
				$message = preg_replace("#@erase_all(.*)#", $this->translator->trans("chatbot.admin.erase_all")."$1", $message);
				$this->getChatRepository()->eraseAll();
				$edited = true;
			#utiliser un autre utilisateur quelconque
			} else if (preg_match("#^@user\[.+\] .+#U", $message)) {
				$username = preg_replace("#@user\[(.+)\] .+#", "$1", $message);
				$user2 = $this->getUserRepository()->findOneByUsername($username);
				$message = preg_replace("#@user\[.+\] (.+)#", "$1", $message);
				if ($user2 !== null) {
					$user = $user2;
					$edited = true;
				}
			#utiliser le chatbot pour s'exprimer
			} else if (preg_match("#^@chatbot#", $message)) {
				$user = $this->getChatbotUser();
				$message = preg_replace("#@chatbot (.+)#", "$1", $message);
				$edited = true;
			#bannir un utilisateur
			} elseif (preg_match("#^@ban\[.+\]#", $message)) {
				$username = preg_replace("#^@ban\[(.+)\].*$#", "$1", $message);
				$user2 = $this->getUserRepository()->findOneByUsername($username);
				if ($user2 !== null) {
					$user2->lock();
					$message = $this->translator->trans(
						'chatbot.admin.ban',
						array(
							'%by%' => $user->getDisplay(),
							'%who%' => $user2->getDisplay(),
							'%why%' => preg_replace("#^@ban\[.+\] (.+)$#", "$1", $message),
							)
						);
					$user = $this->getChatbotUser();
					$edited = true;
				}
			#rétablir un utilisateur
			} elseif (preg_match("#^@deban\[.+\]#", $message)) {
				$username = preg_replace("#^@deban\[(.+)\].*$#", "$1", $message);
				$user2 = $this->getUserRepository()->findOneByUsername($username);
				if ($user2 !== null) {
					$user2->unlock();
					$message = $this->translator->trans(
						'chatbot.admin.deban',
						array(
							'%by%' => $user->getDisplay(),
							'%who%' => $user2->getDisplay(),
							'%why%' => preg_replace("#^@deban\[.+] (.*)$#", "$1", $message),
							)
						);
					$user = $this->getChatbotUser();
					$edited = true;
				}
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
					$this->sendBotMessage($value);
				}
			}
		}
	}

	public function newActuNotification(Actus $actu, User $user)
	{
		$message = $this->translator->trans("chatbot.notifications.new.actu", array(
			'%url%'   => $this->generateRoute('view_actu', array('slug' => $actu->getSlug())),
			'%title%' => $actu->getTitle(),
			'%user%'  => $user->getDisplay(),
			)
		);
		$this->sendBotMessage($message, true);
		return;
	}

	public function newUserNotification(User $user)
	{
		$message = $this->translator->trans(
			'chatbot.notifications.new.user',
			array(
				'%name%' => $user->getDisplay(),
				)
			);
		$this->sendBotMessage($message);
		return;
	}

	private function sendBotMessage($message, $andFlush = false)
	{
		$chatMsg = new Chat;
		$chatMsg->setMessage($message)->setUser($this->getChatbotUser());
		$this->em->persist($chatMsg);
		if ($andFlush) {
			$this->em->flush();
		}
	}

	private function generateRoute($name, $options = array())
	{
		return $this->router->generate(
			$this->parameters['route'][$name],
			$options,
			UrlGeneratorInterface::ABSOLUTE_PATH
			);
	}
}
