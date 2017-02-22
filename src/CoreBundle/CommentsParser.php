<?php
namespace CoreBundle;

use FOS\CommentBundle\Markup\ParserInterface;
use FM\BbcodeBundle\Templating\BbcodeExtension;

class CommentsParser implements ParserInterface
{
	protected $fm_bbcode;
	protected $filter;

	function __construct(BbcodeExtension $fm_bbcode, $filter)
	{
		$this->fm_bbcode = $fm_bbcode;
		$this->filter    = $filter;
	}

	public function parse($raw)
	{
		return $this->fm_bbcode->filter($raw, $this->filter);
	}
}
