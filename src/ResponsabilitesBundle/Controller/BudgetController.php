<?php

namespace ResponsabilitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use ResponsabilitesBundle\Form\Type\ExtraJobFormType;
use ResponsabilitesBundle\Entity\ExtraJob;

class BudgetController extends Controller
{
	public function indexAction(Request $request)
	{
		return $this->render('ResponsabilitesBundle:Budget:index.html.twig');
	}

	public function viewExtraJobAction(Request $request, $year = null)
	{
		if ($year === null) {
			if (getdate()['mon'] >= 9) {
				$year = getdate()['year'];
			} else {
				$year = getdate()['year']-1;
			}
		}

		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('ResponsabilitesBundle:ExtraJob');

		$extraJobs = $repository->getBySchoolYear($year);
		$recettes  = $repository->getRecettesOfSchoolYear($year);

		return $this->render(
			'ResponsabilitesBundle:Budget:view_extra_job.html.twig',
			array(
				'extraJobs'   => $extraJobs,
				'recettes'    => $recettes,
				'year'        => $year,
				'nbExtraJobs' => count($extraJobs),
				)
			);
	}

	public function addExtraJobAction(Request $request)
	{
		// security check
		if (
			!$this->get('security.authorization_checker')->isGranted('ROLE_BUDGET')
			&& !$this->get('security.authorization_checker')->isGranted('ROLE_CHEF_EQUIPE')
			) {
			throw $this->createAccessDeniedException(
				'Vous n\'avez ni la responsabilité budget, ni le rôle de chef d\'équipe.'
				);
		}

		// début de la méthode
		$extraJob = new ExtraJob;

		$form = $this->createForm(ExtraJobFormType::class, $extraJob);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($extraJob);
			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Le nouvel extra job a été enregistré');

			if ($extraJob->getDate()->format('m') >= 9) {
				$year = $extraJob->getDate()->format('Y');
			} else {
				$year = $extraJob->getDate()->format('Y')-1;
			}
			
			return $this->redirectToRoute(
				'responsabilites_budget_extra_job_view',
				array(
					'year' => $year,
					)
				);
		}

		return $this->render(
			'ResponsabilitesBundle:Budget:add_extra_job.html.twig',
			array(
				'form' => $form,
				)
			);
	}
}
