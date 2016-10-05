<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use UserBundle\Form\Type\RoleFormType;

/**
 * RESTful controller managing group CRUD
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RoleController extends Controller
{
	public function viewAction(Request $request)
	{
		$users = $this
			->getDoctrine()
			->getManager()
			->getRepository('UserBundle:User')
			->findAll();

		return $this->render(
			'UserBundle:Role:view.html.twig',
			array(
				'users' => $users,
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_ALLOWED_TO_SWITCH')")
	 */
	public function editAction(Request $request, $username)
	{
		$em = $this
			->getDoctrine()
			->getManager();

		$user = $em
			->getRepository('UserBundle:User')
			->findOneByUsername($username);

		if ($user === null) {
			throw NotFoundHttpException(
				'L\'utilisateur '.$username.' n\'existe pas.'
				);
		}

		$form = $this->createForm(RoleFormType::class, $user);

		if (
			$request->isMethod('POST')
			&& $form->handleRequest($request)->isValid()
			) {

			$em->persist($user);
			$em->flush();

			$request
				->getSession()
				->getFlashBag()
				->add('success', 'Les rôles de l\'utilisateur '.$username.' ont bien été modifiés');

			return $this->redirect('user_role_view');
		}

		return $this->render(
			'UserBundle:Role:edit.html.twig',
			array(
				'form' => $form->createView(),
				'user' => $user,
				)
			);
	}
}
