<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use CoreBundle\FormModels\ContactModel;
use CoreBundle\Form\ContactType;

class IndexController extends Controller
{
	public function indexAction()
	{
		return $this->render('CoreBundle:Index:index.html.twig');
	}

	public function contactAction(Request $request)
	{
		$mail = new ContactModel();
		$form = $this->get('form.factory')->create(ContactType::class, $mail);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			
			$email = new \Swift_Message;
			$email->setSubject('Contact – '.$mail->getObjet());
			$email->setReplyTo($mail->getEmail(), $mail->getNom().' '.$mail->getPrenom());
			$email->setFrom($mail->getEmail());
			$email->setBody('Envoyé par '.$mail->getNom().' '.$mail->getPrenom().'( '.$mail->getEmail().' )

'.$mail->getContenu(), 'text/plain');
			$email->setTo($this->container->getParameter('mailer_user'));
			$email->setSender($this->container->getParameter('mailer_user'));

			$this->get('mailer')->send($email);

			$request->getSession()->getFlashBag()->add('success', 'Votre e-mail a bien été envoyé')
			
			return $this->redirectToRoute('index');
		}

		return $this->render('CoreBundle:Index:contact.html.twig', array(
			'form' => $form->createView()
		));
	}

	public function linksAction()
	{
		return $this->render('CoreBundle:Index:links.html.twig');
	}

	public function termsAction()
	{
		return $this->render('CoreBundle:Index:terms.html.twig');
	}

	public function creditsAction()
	{
		return $this->render('CoreBundle:Index:credits.html.twig');
	}

}
