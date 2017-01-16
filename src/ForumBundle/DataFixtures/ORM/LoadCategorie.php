<?php

namespace ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ForumBundle\Entity\Categorie;

class LoadCategorie implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
	}
}
