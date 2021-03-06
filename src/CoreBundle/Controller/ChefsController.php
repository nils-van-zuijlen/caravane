<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use CoreBundle\Mailer\ChefsEmail;
use CoreBundle\Form\Type\ChefsEmailFormType;

class ChefsController extends Controller
{
	/**
	 * @Security("has_role('ROLE_CHEF')")
	 */
	public function sendEmailAction(Request $request)
	{
		$email = new ChefsEmail;

		$email->setFromUser($this->getUser());

		$form = $this->createForm(ChefsEmailFormType::class, $email);

		if (
			$request->isMethod('POST')
			&& $form->handleRequest($request)->isValid()
			) {
			$this->get('core.mailer')->sendChefsEmail($email);

			$request->getSession()->getFlashBag()->add('success', 'chefs.send_email.flash');

			return $this->redirectToRoute('core_chefs_index');
		}

		return $this->render(
			'CoreBundle:Chefs:send_email.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_CHEF')")
	 */
	public function indexAction(Request $request)
	{
		return $this->render('CoreBundle:Chefs:index.html.twig');
	}
}
