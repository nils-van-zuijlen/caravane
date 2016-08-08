<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreBundle:Index:index.html.twig', array(
            // ...
        ));
    }

    public function contactAction()
    {
        return $this->render('CoreBundle:Index:contact.html.twig', array(
            // ...
        ));
    }

    public function linksAction()
    {
        return $this->render('CoreBundle:Index:links.html.twig', array(
            // ...
        ));
    }

    public function termsAction()
    {
        return $this->render('CoreBundle:Index:terms.html.twig', array(
            // ...
        ));
    }

    public function creditsAction()
    {
        return $this->render('CoreBundle:Index:credits.html.twig', array(
            // ...
        ));
    }

}
