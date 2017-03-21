<?php

namespace ServiceBundle\Controller;

use Ijanki\Bundle\FtpBundle\Exception\FtpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FileController
 * @package ServiceBundle\Controller
 * @Route("/file")
 */
class FileController extends Controller
{
	public function indexAction($name)
	{
		return $this->render('', array('name' => $name));
	}

	/**
	 * @Route("/upload")
	 * @inheritdoc
	 */
	public function uploadTestAction(Request $request)
	{
		if ($request->getMethod() == 'GET')
			return $this->render('@Service/File/upload_test.html.twig');
		else {
			$source = $request->files->get('img');
			try {
				$fileName     = md5(uniqid()) . '.' . $source->guessExtension();
				$ftp          = $this->get('ijanki_ftp');
				$ftp_server   = $this->getParameter('aliyun.ftp_server');
				$ftp_username = $this->getParameter('aliyun.ftp_username');
				$ftp_password = $this->getParameter('aliyun.ftp_password');
				$ftp->connect($ftp_server);
				$ftp->login($ftp_username, $ftp_password);
				$ftp->put('/htdocs/' . $fileName, $source, FTP_BINARY);
			} catch (FtpException $e) {
				throw new Exception($e->getMessage());
			}

			$this->addFlash('success', 'upload success:' . $fileName);
			return $this->render('@Service/File/upload_test.html.twig');
		}
	}
}
