<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use ForumBundle\Entity\Forum;
use ForumBundle\Form\ForumType;

class ForumController extends Controller
{
	public function viewAction(Request $request, $categorie, $slug)
	{
		$forum = $this
			->getDoctrine()
			->getManager()
			->getRepository('ForumBundle:Forum')
			->findOneBySlug($slug);

		if ($forum === null)
			throw $this->createNotFoundException('Le forum '.$slug.' n\'existe pas.');

		if ($forum->getCategorie()->getSlug() != $categorie)
		{
			throw $this
				->createNotFoundException(
					'Le forum '.$slug
					.' n\'existe pas dans la categorie '.$categorie
					);
		}

		return $this->render(
			'ForumBundle:Forum:view.html.twig',
			array(
				'forum'     => $forum,
				'categorie' => $forum->getCategorie(),
				)
			);
	}

	public function viewCategoriesAction(Request $request)
	{
		$categories = $this
			->getDoctrine()
			->getManager()
			->getRepository('ForumBundle:Categorie')
			->findAll();

		return $this->render(
			'ForumBundle:Forum:view_categories.html.twig',
			array(
				'categories' => $categories,
				)
			);
	}

	public function viewCategorieAction(Request $request, $slug)
	{
		$em = $this
			->getDoctrine()
			->getManager();
		$categorie = $em
			->getRepository('ForumBundle:Categorie')
			->findOneBySlug($slug);

		if ($categorie === null)
			throw $this->createNotFoundException('La categorie '.$slug.' n\'existe pas');

		$forums = $em
			->getRepository('ForumBundle:Forum')
			->findByCategorie($categorie);

		return $this->render(
			'ForumBundle:Forum:view_categorie.html.twig',
			array(
				'categorie' => $categorie,
				'forums'    => $forums,
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_USER')")
	 */
	public function addForumAction(Request $request)
	{
		$forum = new Forum;

		$forum->setUser($this->getUser());

		$form = $this->createForm(ForumType::class, $forum);

		if (
			   $request->isMethod('POST')
			&& $form->handleRequest($request)->isValid()
			)
		{
			$em = $this
				->getDoctrine()
				->getManager();

			$em->persist($forum);
			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Forum créé');

			return $this->redirectToRoute(
				'forum_forum_view',
				array(
					'slug'      => $forum->getSlug(),
					'categorie' => $forum->getCategorie()->getSlug(),
					)
				);
		}

		return $this->render(
			'ForumBundle:Forum:add_forum.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_USER')")
	 */
	public function editForumAction(Request $request, $categorie, $slug)
	{
		$em = $this
			->getDoctrine()
			->getManager();

		$em
			->getRepository('ForumBundle:Forum')
			->findOneBySlug($slug);

		if ($forum === null)
			throw $this->createNotFoundException('Le forum '.$slug.' n\'existe pas.');

		if ($forum->getCategorie()->getSlug() != $categorie)
		{
			throw $this
				->createNotFoundException(
					'Le forum '.$slug
					.' n\'existe pas dans la categorie '.$categorie
					);
		}

		$form = $this->createForm(ForumType::class, $forum);

		if (
			   $request->isMethod('POST')
			&& $form->handleRequest($request)->isValid()
			)
		{
			$em->flush();

			$request
				->getSession()
				->getFlashBag()
				->add('success', 'Forum '.$forum->getTitle().' modifié');

			return $this->redirectToRoute(
				'forum_forum_view',
				array(
					'slug'      => $forum->getSlug(),
					'categorie' => $forum->getCategorie()->getSlug(),
					)
				);
		}

		return $this->render(
			'ForumBundle:Forum:edit_forum.html.twig',
			array(
				'form'      => $form->createView(),
				'forum'     => $forum,
				'categorie' => $categorie,
				)
			);
	}
}
