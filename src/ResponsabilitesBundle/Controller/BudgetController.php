<?php

namespace ResponsabilitesController\Controller;

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
}
