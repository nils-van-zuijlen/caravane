<?php
namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;

/**
 * The threads of the FOSCommentBundle
 * 
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Thread extends BaseThread
{
	/**
	 * @var string $id
	 *
	 * @ORM\Id
	 * @ORM\Column(type="string")
	 */
	protected $id;
}
