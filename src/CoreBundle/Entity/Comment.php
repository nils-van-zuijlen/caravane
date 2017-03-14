<?php
namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\CommentBundle\Model\RawCommentInterface;

/**
 * The comments of the FOSCommentBundle
 * 
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Comment extends BaseComment implements SignedCommentInterface, RawCommentInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * Thread of this comment
	 *
	 * @var Thread
	 * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Thread")
	 */
	protected $thread;

	/**
	 * Author of the comment
	 *
	 * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
	 * @var User
	 */
	protected $author;
	
	/**
	 * @ORM\Column(name="rawBody", type="text", nullable=true)
	 * @var string
	 */
	protected $rawBody;

	public function setAuthor(UserInterface $author)
	{
		$this->author = $author;
	}

	public function getAuthor()
	{
		return $this->author;
	}

	public function getAuthorName()
	{
		if (null === $this->getAuthor()) {
			return 'Anonymous';
		}

		return $this->getAuthor()->getDisplay();
	}

	/**
	 * Gets the raw processed html.
	 *
	 * @return string
	 */
	public function getRawBody()
	{
		return $this->rawBody;
	}

	/**
	 * Sets the processed body with raw html.
	 *
	 * @param string $rawBody
	 */
	public function setRawBody($rawBody)
	{
		$this->rawBody = $rawBody;
		return $this;
	}
}
