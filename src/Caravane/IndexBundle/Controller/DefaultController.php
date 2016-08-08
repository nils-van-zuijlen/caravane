<?php

namespace Caravane\IndexBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CaravaneIndexBundle:Default:index.html.twig');
    }
}
