<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

use UserBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\GroupRepository")
 * @ORM\Table(name="equipes")
 */
class Group extends BaseGroup
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", inversedBy="groups", cascade={"persist"})
	 * @ORM\JoinTable(name="fos_user_user_group",
	 *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
	 *     )
	 */
	protected $users;

	/**
	 * Add user
	 *
	 * @param User $user
	 *
	 * @return Group
	 */
	public function addUser(User $user)
	{
		$this->users[] = $user;
		$user->addGroup($this);
		return $this;
	}

	/**
	 * Remove user
	 *
	 * @param User $user
	 */
	public function removeUser(User $user)
	{
		$this->users->removeElement($user);
		$user->removeGroup($this);
	}

	/**
	 * Get users
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getUsers()
	{
		return $this->users;
	}
}
