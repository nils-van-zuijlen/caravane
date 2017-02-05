<?php

namespace ForumBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ForumBundle extends Bundle
{
	public function getParent()
	{
		return 'DForumBundle';
	}
}
