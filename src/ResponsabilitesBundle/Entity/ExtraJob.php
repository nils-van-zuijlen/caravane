<?php

namespace ResponsabilitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ExtraJob
 *
 * @ORM\Table(name="extra_job")
 * @ORM\Entity(repositoryClass="ResponsabilitesBundle\Repository\ExtraJobRepository")
 */
class ExtraJob
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="montant", type="decimal", precision=10, scale=2)
	 * @Assert\Range(min=0.01, max=99999999.99, minMessage="Vous êtes sérieux?", maxMessage="Tout ça?! Faites le en deux fois SVP.")
	 * 
	 */
	private $montant;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(type="date")
	 * @Assert\Date()
	 */
	private $date;

	/**
	 * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Group")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $equipe;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 * @Assert\Type("string")
	 */
	private $commentaires = '';

	/**
	 * @var string
	 *
	 * @ORM\Column(name="slug", type="string", length=255, unique=true)
	 * @Gedmo\Slug(fields={"titre"}, updatable=false)
	 */
	private $slug;


	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set montant
	 *
	 * @param string $montant
	 *
	 * @return ExtraJob
	 */
	public function setMontant($montant)
	{
		$this->montant = $montant;

		return $this;
	}

	/**
	 * Get montant
	 *
	 * @return string
	 */
	public function getMontant()
	{
		return $this->montant;
	}

	/**
	 * Set date
	 *
	 * @param \DateTime $date
	 *
	 * @return ExtraJob
	 */
	public function setDate($date)
	{
		$this->date = $date;

		return $this;
	}

	/**
	 * Get date
	 *
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Set commentaires
	 *
	 * @param string $commentaires
	 *
	 * @return ExtraJob
	 */
	public function setCommentaires($commentaires)
	{
		$this->commentaires = $commentaires;

		return $this;
	}

	/**
	 * Get commentaires
	 *
	 * @return string
	 */
	public function getCommentaires()
	{
		return $this->commentaires;
	}

	/**
	 * Set slug
	 *
	 * @param string $slug
	 *
	 * @return ExtraJob
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * Get slug
	 *
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * Set equipe
	 *
	 * @param \UserBundle\Entity\Group $equipe
	 *
	 * @return ExtraJob
	 */
	public function setEquipe(\UserBundle\Entity\Group $equipe)
	{
		$this->equipe = $equipe;

		return $this;
	}

	/**
	 * Get equipe
	 *
	 * @return \UserBundle\Entity\Group
	 */
	public function getEquipe()
	{
		return $this->equipe;
	}
}