<?php

namespace ResponsabilitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use ResponsabilitesBundle\Entity\Menu;
use ResponsabilitesBundle\Form\Type\MenuFormType;

class IntendanceController extends Controller
{
	public function indexAction(Request $request)
	{
		return $this->render('ResponsabilitesBundle:Intendance:index.html.twig');
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

	/**
	 * @Security("has_role('ROLE_INTENDANCE')")
	 */
	public function newMenuAction(Request $request)
	{
		$menu = new Menu();

		$form = $this->createForm(MenuFormType::class, $menu);
		
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($menu);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Menu enregistré');
			
			return $this->redirectToRoute(
				'responsabilites_intendance_view_menu',
				array(
					'slug' => $menu->getSlug(),
					)
				);
		}

		return $this->render(
			'ResponsabilitesBundle:Intendance:new_menu.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_INTENDANCE')")
	 */
	public function editMenuAction(Request $request, $slug)
	{
		$em = $this->getDoctrine()->getManager();
		$menu = $em
			->getRepository('ResponsabilitesBundle:Menu')
			->findOneBySlug((string) $slug);
		
		if ($menu === null)
			throw $this->createNotFoundException('Le menu '.$slug.' n\'existe pas');
		
		$form = $this->createForm(MenuFormType::class, $menu);
		
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em->persist($menu);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Menu enregistré');
			
			return $this->redirectToRoute(
				'responsabilites_intendance_view_menu',
				array(
					'slug' => $menu->getSlug(),
					)
				);
		}
		
		return $this->render(
			'ResponsabilitesBundle:Intendance:edit_menu.html.twig',
			array(
				'menu' => $menu,
				'form' => $form->createView(),
				)
			);
	}

	public function viewAllMenuAction(Request $request, $page)
	{
		if ($page < 1) {
			throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		}

		$nbPerPage = $this->container->getParameter('nb_per_page');

		$listMenus = $this
			->getDoctrine()
			->getManager()
			->getRepository('ResponsabilitesBundle:Menu')
			->getPaginedMenus($page, $nbPerPage);

		$nbPages = ceil(count($listMenus) / $nbPerPage);

		if ($page > $nbPages) {
			if ($page == 1) {
				$listMenus = array();
				$nbPages = 0;
				$page = 0;
			} else {
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");
			}
		}

		return $this->render(
			'ResponsabilitesBundle:Intendance:view_all_menu.html.twig',
			array(
				'listMenus' => $listMenus,
				'nbPages'=> $nbPages,
				'page'=> $page,
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_INTENDANCE')")
	 */
	public function deleteMenuAction(Request $request, $slug)
	{
		$em = $this->getDoctrine()->getManager();
		$menu = $em->getRepository('ResponsabilitesBundle:Menu');

		if ($menu == null)
			throw $this->createNotFoundException('Le menu '.$slug.' n\'existe pas');

		$em->remove($menu);
		$em->flush();

		$request->getSession()->getFlashBag()->add('success', 'Le menu '.$menu->getTitle().' a été supprimé');

		return $this->redirectToRoute('responsabilites_intendance_view_all_menu');
	}
}
