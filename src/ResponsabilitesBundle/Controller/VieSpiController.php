<?php

namespace ResponsabilitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class VieSpiController extends Controller
{
	public function indexAction()
	{
		return $this->render('ResponsabilitesBundle:VieSpi:index.html.twig');
	}
}
