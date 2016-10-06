<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swift_Message;

use CoreBundle\Mailer\ChefsEmail;
use CoreBundle\Form\EmailFormType;

class ChefsController extends Controller
{
	/**
	 * @Security("has_role('ROLE_CHEF')")
	 */
	public function sendEmailAction(Request $request)
	{
		$email = new ChefsEmail;

		$form = $this->createForm(EmailFormType::class, $email);

		if (
			$request->isMethod('POST')
			&& $form->handleRequest($request)->isValid()
			) {
			$this->get('core.mailer')->sendChefsEmail($email);
			$request->getSession()->getFlashBag()->add('success', 'L\'e-mail a été envoyé');

			return $this->redirect('core_chefs_index');
		}

		return $this->render(
			'CoreBundle:Chefs:send_email.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}
}
