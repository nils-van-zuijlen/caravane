<?php

namespace CoreBundle\Mailer;

use CoreBundle\Mailer\EmailInterface;
use UserBundle\Entity\User;
use UserBundle\Entity\Group;


class ChefsEmail implements EmailInterface
{
	protected $subject;
	protected $body;
	protected $isBcc    = true;
	protected $to       = null;
	protected $toUsers  = array();
	protected $toGroups = array();
	protected $fromUser;

	public function setSubject($subject)
	{ $this->subject = $subject; }
	public function setBody($body)
	{ $this->body = $body; }
	public function setIsBcc($isBcc)
	{ $this->isBcc = $isBcc; }
	public function setToUsers(array $toUsers)
	{ $this->toUsers = $toUsers; }
	public function setToGroups(array $toGroups)
	{ $this->toGroups = $toGroups; }
	public function setFromUser($fromUser)
	{ $this->fromUser = $fromUser; }

	public function getIsBcc()
	{ return $this->isBcc; }
	public function getToUsers()
	{ return $this->toUsers; }
	public function getToGroups()
	{ return $this->toGroups; }
	public function getFromUser()
	{ return $this->fromUser; }

	/** @inheritdoc */
	public function getType()
	{ return 'chefs'; }

	/** @inheritdoc */
	public function getSubject()
	{ return $this->subject; }

	/** @inheritdoc */
	public function getBody()
	{ return $this->body; }

	/** @inheritdoc */
	public function getTo()
	{
		if ($this->to != null) {
			return $this->to;
		}

		$to = array();

		foreach ($this->toGroups as $group) {
			foreach ($group->getUser() as $user) {
				$to[$user->getUsername()] = $user->getEmail();
			}
		}

		foreach ($this->toUsers as $user) {
			$to[$user->getUsername()] = $user->getEmail();
		}

		if ($this->isBcc) {
			$this->to = array(
				'to'  => array(),
				'bcc' => $to,
				);
		} else {
			$this->to = array(
				'to'  => $to,
				'bcc' => array()
				);
		}

		return $this->to;
	}

	/** @inheritdoc */
	public function getFrom()
	{
		return array(
			$this->fromUser->getUsername() => $this->fromUser->getEmail(),
			);
	}
}