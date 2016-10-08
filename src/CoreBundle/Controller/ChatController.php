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
		$message = $request->request->get('message');
		if (!$message) throw new PreconditionRequiredHttpException('No message was sent.');
		
		$user = $this->getUser();

		$chat = new Chat();

		$chat
			->setUser($user)
			->setMessage($message);

		$em = $this->getDoctrine()->getManager();

		$em->persist($chat);
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
