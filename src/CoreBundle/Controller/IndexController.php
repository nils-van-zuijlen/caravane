<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use CoreBundle\FormModels\ContactModel;
use CoreBundle\Form\ContactType;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreBundle:Index:index.html.twig', array(
            // ...
        ));
    }

    public function contactAction(Request $request)
    {
        $mail = new ContactModel();
        $form = $this->get('form.factory')->create(ContactType::class, $mail);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            # envoi de l'e-mail
            
            return $this->redirectToRoute('index');
        }

        return $this->render('CoreBundle:Index:contact.html.twig', array(
            'form' => $form->createView()
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
