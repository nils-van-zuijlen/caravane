<?php

namespace ResponsabilitesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IntendanceController extends Controller
{
    public function indexAction()
    {
        return $this->render('ResponsabilitesBundle:Intendance:index.html.twig', array(
            // ...
        ));
    }

    public function viewMenuAction()
    {
        return $this->render('ResponsabilitesBundle:Intendance:view_menu.html.twig', array(
            // ...
        ));
    }

    public function newMenuAction()
    {
        return $this->render('ResponsabilitesBundle:Intendance:new_menu.html.twig', array(
            // ...
        ));
    }

    public function editMenuAction($slug)
    {
        return $this->render('ResponsabilitesBundle:Intendance:edit_menu.html.twig', array(
            // ...
        ));
    }

    public function viewAllMenuAction()
    {
        return $this->render('ResponsabilitesBundle:Intendance:view_all_menu.html.twig', array(
            // ...
        ));
    }

}
