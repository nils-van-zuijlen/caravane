<?php

namespace ResponsabilitesBundle\Repository;

/**
 * MenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MenuRepository extends \Doctrine\ORM\EntityRepository
{
	public function getPaginedMenus($page, $nbPerPage)
	{
		$query = $this
			->createQueryBuilder('m')
			->orderBy('m.id', 'DESC')
			->getQuery();

		$query
			->setFirstResult(($page-1) * $nbPerPage)
			->setMaxResults($nbPerPage);

		return new Paginator($query, true);
	}
}