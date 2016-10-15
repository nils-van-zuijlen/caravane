<?php

namespace ResponsabilitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
	 */
	private $montant;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="date")
	 */
	private $date;


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
}

