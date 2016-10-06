<?php

namespace CoreBundle\Mailer;

interface EmailInterface
{
	/**
	 * Returns the type of the e-mail
	 * //in array: ["chefs", "contact"]
	 * 
	 * @return string Type
	 */
	public function getType();

	/**
	 * Returns the subject of the e-mail
	 * In non bbcode, non markdown
	 * 
	 * @return string Subject
	 */
	public function getSubject();

	/**
	 * Returns the text body of the message
	 * BBCode formated
	 *
	 * @return string Body
	 */
	public function getBody();

	/**
	 * Returns the To and Bcc receivers
	 * array("to" => array(), "bcc" => array())
	 * 
	 * @return array Receivers
	 */
	public function getTo();

	/**
	 * Returns the From senders
	 * 
	 * @return array array("name" => "email")
	 */
	public function getFrom();
}