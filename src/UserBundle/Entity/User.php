<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Table(name="user")
* @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
*/
class User extends BaseUser
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Group", mappedBy="users", cascade={"persist"})
	 */
	protected $groups;

	/**
	 * @ORM\Column(name="prenom", type="string", length=255)
	 *
	 * @Assert\NotBlank(groups={"Registration", "Profile"}, message="user.user.prenom.not_blank")
	 * @Assert\Length(max=255, groups={"Registration", "Profile"}, maxMessage="user.user.prenom.length.min")
	 */
	protected $prenom;

	/**
	 * @ORM\Column(name="nom", type="string", length=255)
	 *
	 * @Assert\NotBlank(groups={"Registration", "Profile"}, message="user.user.nom.not_blank")
	 * @Assert\Length(max=255, groups={"Registration", "Profile"}, maxMessage="user.user.nom.length.min")
	 */
	protected $nom;

	public function getDisplay()
	{
		return $this->prenom.' '.$this->nom;
	}

	/**
	 * Set prenom
	 *
	 * @param string $prenom
	 *
	 * @return User
	 */
	public function setPrenom($prenom)
	{
		$this->prenom = $prenom;

		return $this;
	}

	/**
	 * Get prenom
	 *
	 * @return string
	 */
	public function getPrenom()
	{
		return $this->prenom;
	}

	/**
	 * Set nom
	 *
	 * @param string $nom
	 *
	 * @return User
	 */
	public function setNom($nom)
	{
		$this->nom = $nom;

		return $this;
	}

	/**
	 * Get nom
	 *
	 * @return string
	 */
	public function getNom()
	{
		return $this->nom;
	}
}
