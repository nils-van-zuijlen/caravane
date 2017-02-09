<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use CoreBundle\Entity\Event;
use CoreBundle\Form\Type\EventType;

class EventController extends Controller
{
	public function viewByYearAction($annee)
	{
		$date1 = new \DateTime($annee.'/01/01');
		$date2 = new \DateTime(($annee + 1).'/01/01');

		return $this->viewEventsByDateInterval($date1, $date2);
	}

	public function viewByMonthAction($annee, $mois)
	{
		$date1 = new \DateTime($annee.'/'.$mois.'/01');
		$date2 = new \DateTime($annee.'/'.($mois + 1).'/01');

		return $this->viewEventsByDateInterval($date1, $date2);
	}

	public function viewByDayAction($annee, $mois, $jour)
	{
		$date1 = new \DateTime($annee.'/'.$mois.'/'.$jour);
		$date2 = new \DateTime($annee.'/'.$mois.'/'.($jour + 1));

		return $this->viewEventsByDateInterval($date1, $date2);
	}

	/**
	 * @Security("has_role('ROLE_COMMUNICATION')")
	 */
	public function addAction(Request $request)
	{
		$event = new Event();

		$form = $this->createForm(EventType::class, $event);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$em = $this->getDoctrine()->getManager();
			$em->persist($event);
			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'event.add.flash');

			return $this->redirectToRoute(
				'core_event_viewone',
				array('slug' => $event->getSlug())
				);
		}

		return $this->render(
			'CoreBundle:Event:add.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}

	public function viewOneAction(Request $request, $slug)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('CoreBundle:Event');
		$event = $repository->findOneBySlug((string) $slug);

		if (null === $event)
			throw $this->createNotFoundException("L'évenement ".$slug." n'existe pas.");

		return $this->render(
			'CoreBundle:Event:view_one.html.twig',
			array(
				'event' => $event,
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_COMMUNICATION')")
	 */
	public function editAction(Request $request, $slug)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('CoreBundle:Event');

		$event = $repository->findOneBySlug((string) $slug);

		if ($event === null)
			throw $this->createNotFoundException("L'évenement ".$slug." n'existe pas.");

		$form = $this->createForm(EventType::class, $event);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'event.edit.flash');

			return $this->redirectToRoute(
				'core_event_viewone',
				array('slug' => $event->getSlug())
				);
		}

		return $this->render(
			'CoreBundle:Event:edit.html.twig',
			array(
				'form'  => $form->createView(),
				'event' => $event,
				)
			);
	}

	/**
	 * @Security("has_role('ROLE_COMMUNICATION')")
	 */
	public function deleteAction($slug, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('CoreBundle:Event');

		$event = $repository->findOneBySlug((string) $slug);

		if ($event === null)
			throw $this->createNotFoundException("L'évenement ".$slug." n'existe pas.");

		$month = $event->getDateDebut()->format('m');
		$year  = $event->getDateDebut()->format('Y');

		$em->remove($event);
		$em->flush();

		$request->getSession()->getFlashBag()->add('success', 'event.delete.flash');

		return $this->redirectToRoute(
			'core_event_view_by_month',
			array(
				'annee' => $year,
				'mois'  => $month,
				)
			);
	}

	protected function viewEventsByDateInterval($from, $to)
	{
		$events = $this
			->getDoctrine()
			->getManager()
			->getRepository('CoreBundle:Event')
			->getByDateInterval($from, $to);

		return $this->render(
			'CoreBundle:Event:view_by_xxx.html.twig',
			array(
				'events' => $events,
				)
			);
	}
}
