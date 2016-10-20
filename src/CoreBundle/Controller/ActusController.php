<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use CoreBundle\Entity\Actus;
use CoreBundle\Form\ActusType;
use CoreBundle\Form\ActusEditType;

use CoreBundle\Event\NewActuEvent;
use CoreBundle\Event\CaravaneEvents;

class ActusController extends Controller
{
	/**
	 * @Security("has_role('ROLE_COMMUNICATION')")
	 */
	public function addAction(Request $request)
	{
		$actu = new Actus();

		$form = $this->createForm(ActusType::class, $actu);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$em = $this->getDoctrine()->getManager();
			$em->persist($actu);
			$em->flush();

			$event = new NewActuEvent($actu, $this->getUser());
			$this->get('event_dispatcher')->dispatch(CaravaneEvents::NEW_ACTU, $event);

			$request->getSession()->getFlashBag()->add('success', 'Actualité enregistrée');

			return $this->redirectToRoute(
				'core_actus_viewone',
				array('slug' => $actu->getSlug())
				);
		}

		return $this->render(
			'CoreBundle:Actus:add.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_COMMUNICATION')")
	 */
	public function deleteAction($slug, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('CoreBundle:Actus');

		$actu = $repository->getActuAndImageBySlug((string) $slug);

		if ($actu === null)
			throw $this->createNotFoundException("L'actualité ".$slug." n'existe pas.");

		$em->remove($actu);
		$em->flush();

		$request->getSession()->getFlashBag()->add('success', 'Actualité supprimée');

		return $this->redirectToRoute('core_actus_view');
	}

	/**
	 * @Security("has_role('ROLE_COMMUNICATION')")
	 */
	public function editAction(Request $request, $slug)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('CoreBundle:Actus');

		$actu = $repository->getActuAndImageBySlug((string) $slug);

		if ($actu === null)
			throw $this->createNotFoundException("L'actualité ".$slug." n'existe pas.");

		$form = $this->createForm(ActusEditType::class, $actu);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Modifications enregistrées');

			return $this->redirectToRoute(
				'core_actus_viewone',
				array('slug' => $actu->getSlug())
				);
		}

		return $this->render(
			'CoreBundle:Actus:edit.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}

	public function viewoneAction(Request $request, $slug)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('CoreBundle:Actus');

		$actu = $repository->getActuAndImageBySlug((string) $slug);

		return $this->render(
			'CoreBundle:Actus:viewone.html.twig',
			array(
				'actu' => $actu,
				)
			);
	}

	public function viewAction(Request $request, $page)
	{
		if ($page < 1) {
			throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		}

		$nbPerPage = $this->container->getParameter('nb_per_page');

		$listActus = $this
			->getDoctrine()
			->getManager()
			->getRepository('CoreBundle:Actus')
			->getPaginedActus($page, $nbPerPage);

		$nbPages = ceil(count($listActus) / $nbPerPage);

		if ($page > $nbPages) {
			if ($page == 1) {
				$listActus = array();
				$nbPages = 0;
				$page = 0;
			} else {
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");
			}
		}

		return $this->render(
			'CoreBundle:Actus:view.html.twig',
			array(
				'listActus' => $listActus,
				'nbPages'=> $nbPages,
				'page'=> $page,
				)
			);
	}
}
