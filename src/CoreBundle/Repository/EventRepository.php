<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
	public function getByDateInterval(\DateTime $from, \DateTime $to)
	{
		$qb = $this->createQueryBuilder('e');

		$qb
			->where(
				$qb->expr()->gte('e.dateFin', '?1')
				)
			->andWhere(
				$qb->expr()->lte('e.dateDebut', '?2')
				)
			->orderBy('e.dateDebut')
			->setParameters(
				array(
					1 => $from,
					2 => $to,
					)
				);

		return $qb->getQuery()->getResult();
	}
}
