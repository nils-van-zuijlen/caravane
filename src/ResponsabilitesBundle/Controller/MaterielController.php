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
					'id' => $type->getId(),
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
}
