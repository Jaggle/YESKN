<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/12/28
 * Time: 21:39
 */

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 * Class DefaultController
 * @package AppBundle\Controller\Admin
 */
class DefaultController extends BaseController
{
	/**
	 * @Route("", name="admin_index")
	 * @return Response
	 */
	public function indexAction()
	{
		return $this->render('@App/Admin/index.html.twig');
	}

	/**
	 * @Route("/push", name="admin_push")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function pushAction(Request $request)
	{
		$ch = curl_init('http://yeskn.com:2121');

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, [
			'type' => $request->get('type'),
			'content' => $request->get('content')
		]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);

		if ($res == 'ok') {
			$this->addFlash('success', '推送成功!');
		} else {
			$this->addFlash('error', '推送失败!');
		}

		return $this->redirectToRoute('admin_index');

	}
}