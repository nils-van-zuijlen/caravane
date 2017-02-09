<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Actus
 *
 * @ORM\Table(name="actus")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ActusRepository")
 */
class Actus
{
	const ALLOWED_MIME_TYPES = array("image/jpg", "image/gif", "image/jpeg", "image/png", "image/svg");

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
	 * @ORM\Column(name="title", type="string", length=255)
	 * 
	 * @Assert\Length(min=5, max=255, minMessage="core.actus.title.length.min", maxMessage="core.actus.title.length.max")
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content", type="text")
	 *
	 * @Assert\Length(min=5, minMessage="core.actus.content.length.min")
	 */
	private $content;

	/**
	 * @var CoreBundle\Entity\File
	 *
	 * @ORM\OneToOne(targetEntity="CoreBundle\Entity\File", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=false)
	 *
	 * @Assert\Valid()
	 */
	private $image;

	/**
	 * @var string
	 *
	 * @Gedmo\Slug(fields={"title"}, updatable=false)
	 * @ORM\Column(name="slug", type="string", length=255, unique=true)
	 */
	private $slug;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_publication", type="datetime")
	 */
	private $datePublication;


	public function __construct()
	{
		$this->datePublication = new \DateTime;
	}

	/**
	 * @Assert\IsTrue(message="core.actus.image.is_image")
	 */
	public function isImageFile()
	{
		if ($this->image->getFile() !== null)
			return in_array($this->image->getFile()->getMimeType(), self::ALLOWED_MIME_TYPES);
		else
			return true;
	}

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
	 * Set title
	 *
	 * @param string $title
	 *
	 * @return Actus
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set content
	 *
	 * @param string $content
	 *
	 * @return Actus
	 */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Set slug
	 *
	 * @param string $slug
	 *
	 * @return Actus
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
	 * Set image
	 *
	 * @param File $image
	 *
	 * @return Actus
	 */
	public function setImage(File $image)
	{
		$this->image = $image;

		return $this;
	}

	/**
	 * Get image
	 *
	 * @return \CoreBundle\Entity\File
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * Set datePublication
	 *
	 * @param \DateTime $datePublication
	 *
	 * @return Actus
	 */
	public function setDatePublication(\DateTime $datePublication)
	{
		$this->datePublication = $datePublication;

		return $this;
	}

	/**
	 * Get datePublication
	 *
	 * @return \DateTime
	 */
	public function getDatePublication()
	{
		return $this->datePublication;
	}
}
