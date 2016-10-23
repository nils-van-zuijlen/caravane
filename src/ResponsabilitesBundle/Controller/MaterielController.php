<?php

namespace ResponsabilitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
	
	public function newTypeAction(Request $request)
	{
		$type = new Type;
		
		$form = $this->createForm(TypeFormType::class, $type);
		
		if ($request->isType('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($type);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Type d\'objet créé');
			
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

	public function newObjetAction(Request $request)
	{
		$objet = new Objet;
		
		$form = $this->createForm(ObjetFormType::class, $objet);
		
		if ($request->isType('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($objet);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Objet enregistré');
			
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
			
			$request->getSession()->getFlashBag()->add('success', 'Type d\'objet modifié');
			
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

	public function editObjetAction(Request $request, $objet)
	{
		$objet_id = (int) $objet;
		$em = $this->getDoctrine()->getManager();

		$objet = $em
			->getRepository('ResponsabilitesBundle:Objet')
			->find($objet_id);

		if (null === $objet)
			throw $this->createNotFoundException("L'objet n°".$objet." n'existe pas.");
		
		$form = $this->createForm(ObjetFormType::class, $objet);
		
		if ($request->isType('POST') && $form->handleRequest($request)->isValid()) {
			$em->persist($objet);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Modifications de l\'objet enregistrées');
			
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
}
