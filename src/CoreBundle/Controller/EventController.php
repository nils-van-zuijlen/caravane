<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use CoreBundle\Entity\Event;
use CoreBundle\Form\Type\EventType;

class EventController extends Controller
{
	public function viewByYearAction($year)
	{
		$this->checkDate($year);
		
		$calendr = $this->get('calendr');

		$cYear  = $calendr->getYear($year);
		$events = $calendr->getEvents($cYear);

		return $this->render(
			'CoreBundle:Event:view_by_year.html.twig',
			array(
				'year'   => $cYear,
				'events' => $events,
		));
	}

	public function viewByMonthAction($year, $month)
	{
		$this->checkDate($year, $month);
		
		$calendr = $this->get('calendr');

		$cMonth = $calendr->getMonth($year, $month);
		$events = $calendr->getEvents($cMonth);

		return $this->render(
			'CoreBundle:Event:view_by_month.html.twig',
			array(
				'month'  => $cMonth,
				'events' => $events,
				)
			);
	}

	public function viewByDayAction($year, $month, $day)
	{
		$this->checkDate($year, $month, $day);
		
		$calendr = $this->get('calendr');

		$cDay   = $calendr->getDay($year, $month, $day);
		$cMonth = $calendr->getMonth($year, $month);
		$events = $calendr->getEvents($cMonth)->find($cDay);

		return $this->render(
			'CoreBundle:Event:view_by_day.html.twig',
			array(
				'day'    => $cDay,
				'events' => $events,
				)
			);
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
				array('uid' => $event->getUid())
				);
		}

		return $this->render(
			'CoreBundle:Event:add.html.twig',
			array(
				'form' => $form->createView(),
				)
			);
	}

	public function viewOneAction(Request $request, $uid)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('CoreBundle:Event');
		$event = $repository->findOneByUid((string) $uid);

		if (null === $event)
			throw $this->createNotFoundException("L'évenement ".$uid." n'existe pas.");

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
	public function editAction(Request $request, $uid)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('CoreBundle:Event');

		$event = $repository->findOneByUid((string) $uid);

		if ($event === null)
			throw $this->createNotFoundException("L'évenement ".$uid." n'existe pas.");

		$form = $this->createForm(EventType::class, $event);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'event.edit.flash');

			return $this->redirectToRoute(
				'core_event_viewone',
				array('uid' => $event->getUid())
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
	public function deleteAction($uid, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('CoreBundle:Event');

		$event = $repository->findOneByUid((string) $uid);

		if ($event === null)
			throw $this->createNotFoundException("L'évenement ".$uid." n'existe pas.");

		$month = $event->getBegin()->format('m');
		$year  = $event->getBegin()->format('Y');

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

	protected function checkDate(int $year, int $month = 1, int $day = 1)
	{
		if (!checkdate($month, $day, $year)) {
			throw $this->createNotFoundException('Date '.$day.'/'.$month.'/'.$year.' is not valid.');
		}
	}
}
