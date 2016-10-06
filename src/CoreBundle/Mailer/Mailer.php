<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\Mailer;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

use CoreBundle\Mailer\EmailInterface;

class Mailer
{
	protected $mailer;
	protected $router;
	protected $twig;
	protected $parameters;

	public function __construct(Swift_Mailer $mailer, UrlGeneratorInterface $router, Twig_Environment $twig, array $parameters)
	{
		$this->mailer     = $mailer;
		$this->router     = $router;
		$this->twig       = $twig;
		$this->parameters = $parameters;
	}

	public function sendChefsEmail(EmailInterface $email)
	{
		if ($email->getType() != 'chefs') {
			throw new \UnexpectedValueException(
				'Expected EmailInterface of type "chefs", got type "'.$email->getType().'".'
				);
		}

		$to  = $email->getTo()['to'];
		$bcc = $email->getTo()['bcc'];

		if ($to == null) {
			$to = array();
		}
		if ($bcc == null) {
			$bcc = array();
		}

		$this
			->sendMessage(
				array(
					"subject" => $email->getSubject(),
					"body"    => $email->getBody(),
					),
				$this->parameters['template']['chefs'],
				$email->getFrom(),
				$to,
				$bcc
				);
	}

	protected function sendMessage($context, $templateName, $fromEmails, $toEmails, $bccEmails)
	{
		$context  = $this->twig->mergeGlobals($context);
		$template = $this->twig->loadTemplate($templateName);

		$subject  = $template->renderBlock('subject', $context);
		$textBody = $template->renderBlock('body_text', $context);
		$htmlBody = $template->renderBlock('body_html', $context);

		$message = Swift_Message::newInstance()
			->setSubject($subject)
			->setFrom($fromEmail, $fromName)
			->setReplyTo($fromEmail, $fromName))
			->setSender($this->parameters['mailer_user'])
			->setTo($toEmails)
			->setBcc($bccEmails)
			->setBody($htmlBody, 'text/html')
			->addPart($textBody, 'text/plain');

		$this->mailer->send($message);
	}
}
