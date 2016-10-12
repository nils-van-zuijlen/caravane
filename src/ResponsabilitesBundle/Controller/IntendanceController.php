<?php

namespace ResponsabilitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class IntendanceController extends Controller
{
	public function indexAction(Request $request)
	{
		return $this->render(
			'ResponsabilitesBundle:Intendance:index.html.twig',
			array(
				#
				)
			);
	}

	public function viewMenuAction(Request $request, $slug)
	{
		$menu = $this
			->getDoctrine()
			->getManager()
			->getRepository('ResponsabilitesBundle:Menu')
			->findOneBySlug((string) $slug);
		
		if ($menu === null)
			throw $this->createNotFoundException('Le menu '.$slug.' n\'existe pas');
		
		return $this->render(
			'ResponsabilitesBundle:Intendance:view_menu.html.twig',
			array(
				'menu' => $menu,
				)
			);
	}

	public function newMenuAction(Request $request)
	{
		return $this->render(
			'ResponsabilitesBundle:Intendance:new_menu.html.twig',
			array(
				#
				)
			);
	}

	public function editMenuAction(Request $request, $slug)
	{
		return $this->render(
			'ResponsabilitesBundle:Intendance:edit_menu.html.twig',
			array(
				#
				)
			);
	}

	public function viewAllMenuAction(Request $request)
	{
		return $this->render(
			'ResponsabilitesBundle:Intendance:view_all_menu.html.twig',
			array(
				#
				)
			);
	}

}
