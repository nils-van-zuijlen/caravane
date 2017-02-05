<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use CoreBundle\FormModels\ContactModel;
use CoreBundle\Form\Type\ContactType;

class IndexController extends Controller
{
	const NB_ACTUS_IN_CAROUSEL = 4;

	public function indexAction()
	{
		$repository = $this->getDoctrine()->getManager()->getRepository('CoreBundle:Actus');

		$actus = $repository->getLast(self::NB_ACTUS_IN_CAROUSEL);

		return $this->render(
			'CoreBundle:Index:index.html.twig',
			array(
				'actus'    => $actus,
				'nb_actus' => count($actus),
				)
			);
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

			$request->getSession()->getFlashBag()->add('success', 'index.contact.flash');
			
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
