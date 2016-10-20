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
					'type'  => $objet->getType()->getId(),
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
}
