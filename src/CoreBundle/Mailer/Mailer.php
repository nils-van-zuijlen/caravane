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
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

use CoreBundle\Mailer\EmailInterface;

class Mailer implements MailerInterface
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

	public function sendConfirmationEmailMessage(UserInterface $user)
	{
		$template = $this->parameters['template']['confirmation'];
		$url = $this->router->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);

		$context = array(
			'user' => $user,
			'confirmationUrl' => $url,
		);

		$this->sendMessage($context, $template, $this->parameters['from_email']['confirmation'], (string) $user->getEmail());
	}

	public function sendResettingEmailMessage(UserInterface $user)
	{
		$template = $this->parameters['template']['resetting'];
		$url = $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);

		$context = array(
			'user' => $user,
			'confirmationUrl' => $url,
		);

		$this->sendMessage($context, $template, $this->parameters['from_email']['resetting'], (string) $user->getEmail());
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

		if ($to === null) {
			$to = array();
		}
		if ($bcc === null) {
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

	public function sendContactEmail(EmailInterface $email)
	{
		if ($email->getType() != 'contact') {
			throw new \UnexpectedValueException(
				'Expected EmailInterface of type "contact", got type "'.$email->getType().'".'
				);
		}

		$to  = $email->getTo()['to'];
		$bcc = $email->getTo()['bcc'];

		if ($to === null) {
			$to = array();
		}
		if ($bcc === null) {
			$bcc = array();
		}

		if (strtolower($to[0]." ") == "contact ") {
			$to = $this->parameters['to_email']['contact'];
		}

		$this
			->sendMessage(
				array(
					"subject"      => $email->getSubject(),
					"body"         => $email->getBody(),
					"display_name" => $email->getDisplay(),
					),
				$this->parameters['template']['contact'],
				$email->getFrom(),
				$to,
				$bcc
				);
	}

	protected function sendMessage($context, $templateName, $fromEmails, $toEmails, $bccEmails = null)
	{
		$context  = $this->twig->mergeGlobals($context);
		$template = $this->twig->loadTemplate($templateName);

		$subject  = $template->renderBlock('subject', $context);
		$textBody = $template->renderBlock('body_text', $context);
		$htmlBody = $template->renderBlock('body_html', $context);

		$message = Swift_Message::newInstance()
			->setSubject($subject)
			->setFrom($fromEmails)
			->setReplyTo($fromEmails)
			->setSender($this->parameters['mailer_user'])
			->setTo($toEmails)
			->setBcc($bccEmails)
			->setBody($htmlBody, 'text/html')
			->addPart($textBody, 'text/plain');

		$this->mailer->send($message);
	}
}
