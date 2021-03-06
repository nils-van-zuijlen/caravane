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

	/**
	 * @ORM\Column(name="locked", type="boolean")
	 */
	protected $locked;

	public function __construct()
	{
		$this->locked = false;
		parent::__construct();
	}

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

	public function lock()
	{
		$this->setLocked(true);
		return $this;
	}
	public function unlock()
	{
		$this->setLocked(false);
		return $this;
	}

	/**
	 * Set locked
	 *
	 * @param boolean $locked
	 *
	 * @return User
	 */
	public function setLocked($locked)
	{
		$this->locked = $locked;

		return $this;
	}

	/**
	 * Get locked
	 *
	 * @return boolean
	 */
	public function getLocked()
	{
		return $this->locked;
	}

	/**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return !$this->locked;
    }
}
