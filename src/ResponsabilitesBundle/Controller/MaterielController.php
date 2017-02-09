<?php

namespace ResponsabilitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use ResponsabilitesBundle\Entity\Objet;
use ResponsabilitesBundle\Entity\TypeObjet as Type;
use ResponsabilitesBundle\Form\Type\ObjetFormType;
use ResponsabilitesBundle\Form\Type\TypeObjetFormType as TypeFormType;

class MaterielController extends Controller
{
	public function indexAction(Request $request)
	{
		return $this->render('ResponsabilitesBundle:Materiel:index.html.twig');
	}

	/**
	 * @Security("has_role('ROLE_BUDGET')")
	 */
	public function newTypeAction(Request $request)
	{
		$type = new Type;
		
		$form = $this->createForm(TypeFormType::class, $type);
		
		if ($request->isType('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($type);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'materiel.flash.type.add');
			
			return $this->redirectToRoute(
				'responsabilites_materiel_view_type',
				array(
					'type' => $type->getId(),
					)
				);
		}
		
		return $this->render(
			'ResponsabilitesBundle:Materiel:new_type.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_BUDGET')")
	 */
	public function newObjetAction(Request $request)
	{
		$objet = new Objet;
		
		$form = $this->createForm(ObjetFormType::class, $objet);
		
		if ($request->isType('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($objet);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'materiel.flash.objet.add');
			
			return $this->redirectToRoute(
				'responsabilites_materiel_view_objet',
				array(
					'objet' => $objet->getId(),
					)
				);
		}
		
		return $this->render(
			'ResponsabilitesBundle:Materiel:new_objet.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}

	public function viewTypeAction(Request $request, $type)
	{
		$typeObjet = $this
			->getDoctrine()
			->getManager()
			->getRepository('ResponsabilitesBundle:TypeObjet')
			->getWithObjetsById($type);

		if (null === $typeObjet)
			throw $this->createNotFoundException("Le type d'objet n°".$type." n'existe pas.");

		return $this->render(
			'ResponsabilitesBundle:Materiel:view_type.html.twig',
			array(
				'type' => $typeObjet,
				)
			);
	}

	public function viewObjetAction(Request $request, $objet)
	{
		$ob_jet = $this
			->getDoctrine()
			->getManager()
			->getRepository('ResponsabilitesBundle:Objet')
			->getWithTypeById($objet);

		if (null === $ob_jet)
			throw $this->createNotFoundException("L'objet n°".$objet." n'existe pas.");

		return $this->render(
			'ResponsabilitesBundle:Materiel:view_objet.html.twig',
			array(
				'objet' => $ob_jet,
				)
			);
	}

	public function viewAllTypeAction(Request $request)
	{
		$types = $this
			->getDoctrine()
			->getManager()
			->getRepository('ResponsabilitesBundle:TypeObjet')
			->findAll();

		return $this->render(
			'ResponsabilitesBundle:Materiel:view_all_type.html.twig',
			array(
				'types' => $types,
				)
			);
	}

	public function viewAllObjetAction(Request $request)
	{
		$objets = $this
			->getDoctrine()
			->getManager()
			->getRepository('ResponsabilitesBundle:Objet')
			->findAll();

		return $this->render(
			'ResponsabilitesBundle:Materiel:view_all_objet.html.twig',
			array(
				'objets' => $objets,
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_BUDGET')")
	 */
	public function editTypeAction(Request $request, $type)
	{
		$type_id = (int) $type;
		$em = $this->getDoctrine()->getManager();

		$type = $em
			->getRepository('ResponsabilitesBundle:TypeObjet')
			->find($type_id);

		if (null === $type)
			throw $this->createNotFoundException("Le type d'objet n°".$type_id." n'existe pas.");
		
		$form = $this->createForm(TypeFormType::class, $type);
		
		if ($request->isType('POST') && $form->handleRequest($request)->isValid()) {
			$em->persist($type);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'materiel.flash.type.edit');
			
			return $this->redirectToRoute(
				'responsabilites_materiel_view_type',
				array(
					'type' => $type->getId(),
					)
				);
		}
		
		return $this->render(
			'ResponsabilitesBundle:Materiel:edit_type.html.twig',
			array(
				'form' => $form->createView(),
				'type' => $type,
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_BUDGET')")
	 */
	public function editObjetAction(Request $request, $objet)
	{
		$objet_id = (int) $objet;
		$em = $this->getDoctrine()->getManager();

		$objet = $em
			->getRepository('ResponsabilitesBundle:Objet')
			->find($objet_id);

		if (null === $objet)
			throw $this->createNotFoundException("L'objet n°".$objet_id." n'existe pas.");
		
		$form = $this->createForm(ObjetFormType::class, $objet);
		
		if ($request->isType('POST') && $form->handleRequest($request)->isValid()) {
			$em->persist($objet);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'materiel.flash.objet.edit');
			
			return $this->redirectToRoute(
				'responsabilites_materiel_view_objet',
				array(
					'objet' => $objet->getId(),
					)
				);
		}
		
		return $this->render(
			'ResponsabilitesBundle:Materiel:new_objet.html.twig',
			array(
				'form' => $form->createView(),
				'objet' => $objet,
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_BUDGET')")
	 */
	public function deleteTypeAction(Request $request, $type)
	{
		$type_id = (int) $type;
		$em = $this->getDoctrine()->getManager();

		$type = $em
			->getRepository('ResponsabilitesBundle:TypeObjet')
			->find($type_id);

		if (null === $type)
			throw $this->createNotFoundException("Le type d'objet n°".$type_id." n'existe pas.");
		
		$em->remove($type);
		$em->flush();

		$this->addFlash('success', 'materiel.flash.type.delete');
		
		return $this->redirectToRoute('responsabilites_materiel_view_type');
		
	}

	/**
	 * @Security("has_role('ROLE_BUDGET')")
	 */
	public function deleteObjetAction(Request $request, $objet)
	{
		$objet_id = (int) $objet;
		$em = $this->getDoctrine()->getManager();

		$objet = $em
			->getRepository('ResponsabilitesBundle:Objet')
			->find($objet_id);

		if (null === $objet)
			throw $this->createNotFoundException("L'objet n°".$objet_id." n'existe pas.");
		
		$em->remove($objet);
		$em->flush();

		$this->addFlash('success', 'materiel.flash.objet.delete');

		return $this->redirectToRoute('responsabilites_materiel_view_all_objet');
	}
}
