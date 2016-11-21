<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;

use CoreBundle\Entity\Type\File;

class FileController extends Controller
{
	public function getAction(Request $request, $id)
	{
		$file = $this
			->getDoctrine()
			->getManager()
			->getRepository('CoreBundle:File')
			->find($id);

		if ($file == null || !file_exists($file->getActualPath())) {
			throw $this->createNotFoundException("Le fichier ".$id." n'existe pas.");
		}

		$response = new Response;
		$response->headers->set('Content-Type', $file->getMimeType());
		$response->setContent(readfile($file->getActualPath()));
	}
}
