<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ActusRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActusRepository extends EntityRepository
{
	public function getPaginedActus($page, $nbPerPage)
	{
		$query = $this
			->createQueryBuilder('a')
			->orderBy('a.id', 'DESC')
			->leftJoin('a.image', 'i')
			->addSelect('i')
			->getQuery();

		$query
			->setFirstResult(($page-1) * $nbPerPage)
			->setMaxResults($nbPerPage);

		return new Paginator($query, true);
	}

	public function getActuAndImageBySlug($slug)
	{
		$qb = $this->createQueryBuilder('a');

		$qb
			->addWith('a.slug = :slug')
			->setParameter('slug', $slug)
			->leftJoin('a.image', 'i')
			->addSelect('i');

		return $qb->getQuery()->getOneOrNullResult();
	}
}