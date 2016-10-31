<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\FileRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class File
{
	const UPLOAD_ROOT_DIR = "/var/www/html/Caravane/src/CoreBundle/Files";

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
	 * @ORM\Column(name="mimeType", type="string", length=255)
	 */
	private $mimeType;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="originalName", type="string", length=255)
	 */
	private $originalName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="extension", type="string", length=255)
	 */
	private $extension;

	/**
	 * @Assert\File(
	 * 		maxSize="5M",
	 * 		maxSizeMessage="core.file.max_size",
	 * 		disallowEmptyMessage="core.file.disallow_empty"
	 * 	)
	 */
	private $file;


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
	 * Set mimeType
	 *
	 * @param string $mimeType
	 *
	 * @return File
	 */
	public function setMimeType($mimeType)
	{
		$this->mimeType = $mimeType;

		return $this;
	}

	/**
	 * Get mimeType
	 *
	 * @return string
	 */
	public function getMimeType()
	{
		return $this->mimeType;
	}

	/**
	 * Set originalName
	 *
	 * @param string $originalName
	 *
	 * @return File
	 */
	public function setOriginalName($originalName)
	{
		$this->originalName = $originalName;

		return $this;
	}

	/**
	 * Get originalName
	 *
	 * @return string
	 */
	public function getOriginalName()
	{
		return $this->originalName;
	}

	/**
	 * Get actualPath
	 *
	 * @return string
	 */
	public function getActualPath()
	{
		return self::UPLOAD_ROOT_DIR.'/'.$this->id.'.'.$this->extension;
	}

	public function getFile()
	{
		return $this->file;
	}

	public function setFile(UploadedFile $file = null)
	{
		$this->file = $file;
	}

	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload()
	{
		if ($this->file == null)
			return;

		$this->mimeType = $this->file->getMimeType();
		$this->originalName = $this->file->getClientOriginalName();
		$this->extension = $this->file->guessExtension();
	}

	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function upload()
	{
		if ($this->file == null)
			return;

		$this->file->move(self::UPLOAD_ROOT_DIR, $this->id.'.'.$this->extension );
	}

	/**
	 * @ORM\PostRemove()
	 */
	public function removeUpload()
	{
		$file = self::UPLOAD_ROOT_DIR.'/'.$this->id.'.'.$this->extension;
		if (file_exists($file)) {
			unlink($file);
		}
	}

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return File
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }
}
