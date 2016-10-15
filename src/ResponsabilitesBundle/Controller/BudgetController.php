<?php

namespace ResponsabilitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
				$year = getdate()['year']-1;
			} else {
				$year = getdate()['year'];
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
}
