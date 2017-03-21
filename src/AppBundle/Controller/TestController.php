<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/5/18
 * Time: 21:58
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TestController
 * @package AppBundle\Controller
 * @Route("/test")
 */
class TestController extends Controller
{
	
	/**
	 * @Route("/ajax" , name="test_ajax")
	 * @param Request $request
	 * @return Response
	 */
    public function ajaxAction(Request $request)
    {

        if ($request->isMethod('GET')) {
            return $this->render("test/ajax.html.twig");
        } else {
            $file = $request->files->get('img');
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $photoDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/ajax';
            $file->move($photoDir,$fileName);

            return new Response(json_encode(array(
                'img' => '/uploads/ajax/'.$fileName
            )));
        }
    }
}