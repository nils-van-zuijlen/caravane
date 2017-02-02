<?php
namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
	/**
	 * Ban an user.
	 *
	 * @Security("has_role('ROLE_CHEF')")
	 */
	function banAction($user)
	{
		$em = $this->getDoctrine()->getManager();
		$userObject = $em->getRepository('UserBundle:User')->findOneByUsername($user);
		
		if ($user !== null) {
			$userObject->lock();
			$em->flush();
		} else {
			return $this->createNotFoundHttpException('Attempted to ban a unexisting user');
		}
		
		return $this->redirect('user_role_view');
	}

	/**
	 * Deban an user.
	 *
	 * @Security("has_role('ROLE_CHEF')")
	 */
	function debanAction($user)
	{
		$em = $this->getDoctrine()->getManager();
		$userObject = $em->getRepository('UserBundle:User')->findOneByUsername($user);
		
		if ($user !== null) {
			$userObject->unlock();
			$em->flush();
		} else {
			return $this->createNotFoundHttpException('Attempted to deban a unexisting user');
		}
		
		return $this->redirect('user_role_view');
	}
}
