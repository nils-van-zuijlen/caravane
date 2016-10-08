<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;

use CoreBundle\Entity\Chat;

class ChatController extends Controller
{
	const NB_MESSAGES_A_AFFICHER = 15;

	public function viewAction()
	{
		return $this->render('CoreBundle:Chat:view.html.twig');
	}

	public function sendAction(Request $request)
	{
		#récupération des variables
		$message  = $request->request->get('message');       // message envoyé
		$em       = $this->getDoctrine()->getManager();      // DoctrineEntityManager
		$userRepo = $em->getRepository('UserBundle:User');   // UserRepository
		$chatRepo = $em->getRepository('CoreBundle:Chat');   // ChatRepository
		$chatbot  = $userRepo->findOneByUsername('chatbot'); // Utilisateur chatbot
		$user     = $this->getUser();                        // Utilisateur actuel

		#test de présence du message
		if (!$message)
			throw new PreconditionRequiredHttpException('No message was sent.');

		#admin functions
		if ($this->get('security.authorization_checker')->isGranted('ROLE_CHEF')) {
			#effacer tout le chat en laissant un message (ou pas)
			if (preg_match("#^@erase_all#", $message)) {
				$message = preg_replace("#@erase_all(.*)#", "[b]Chat effacé[/b]$1", $message);
				$chatRepo->eraseAll();
			#utiliser un autre utilisateur quelconque
			} else if (preg_match("#^@user\[.+\] .+#U", $message)) {
				$username = preg_replace("#@user\[(.+)\] .+#", "$1", $message);
				$user2 = $userRepo->findOneByUsername($username);
				$message = preg_replace("#@user\[.+\] (.+)#", "$1", $message);
				if ($user2 != null) {
					$user = $user2;
				}
			#utiliser le chatbot pour s'exprimer
			} else if (preg_match("#^@chatbot#", $message)) {
				$user = $chatbot;
				$message = preg_replace("#@chatbot (.+)#", "$1", $message);
			}
		}

		#enregistrement du message envoyé
		$chat = new Chat();
		$chat
			->setUser($user)
			->setMessage($message);
		$em->persist($chat);

		#easter-eggs
		if ($user !== $chatbot) {
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
						->setUser($chatbot)
						->setMessage($value);
					$em->persist($egg);
				}
			}
		}

		#envoi en BDD
		$em->flush();

		return new Response('', 201);
	}

	public function getmessagesAction()
	{
		$repository = $this->getDoctrine()
			->getManager()
			->getRepository('CoreBundle:Chat');

		$messages = $repository->getLast(self::NB_MESSAGES_A_AFFICHER);

		foreach ($messages as $key => $message) {
			$dateInterval = $message->getSentTime()->diff(new \DateTime);
			if ($dateInterval->days != 0) {
				$string = $dateInterval->format('%aj %hh %im %ss');
			} elseif ($dateInterval->h != 0) {
				$string = $dateInterval->format('%hh %im %ss');
			} elseif ($dateInterval->i != 0) {
				$string = $dateInterval->format('%im %ss');
			} else {
				$string = $dateInterval->format('%ss');
			}
			$messages[$key]->ilYA = $string;
		}

		return $this->render(
			'CoreBundle:Chat:getmessages.html.twig',
			array(
				'messages' => $messages,
				)
			);
	}
}
