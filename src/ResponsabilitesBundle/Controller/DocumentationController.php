<?php

namespace ResponsabilitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DocumentationController extends Controller
{
	public function indexAction()
	{
		return $this->render('ResponsabilitesBundle:Documentation:index.html.twig');
	}
}
