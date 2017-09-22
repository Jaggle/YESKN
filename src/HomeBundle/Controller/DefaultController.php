<?php

/**
 * This file is part of the Geekerism package.
 *
 * (c) Jaggle <jaggle@yeskn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * 网站首页
     *
     * @Route("/")
     * @param $request Request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $redirectUrl = $request->query->get('redirect');
        if ($redirectUrl)
            return $this->redirect($redirectUrl);

        $arr['first_sight'] = !!!$request->cookies->get('first_sight_token');
        $response = $this->render('HomeBundle:Default:index.html.twig',$arr);

        if ($arr['first_sight']) {
            $cookie = new Cookie('first_sight_token', md5(uniqid()));
            $response->headers->setCookie($cookie);
        }

        return $response;
    }

    /**
     * 我的简历
     *
     * @Route("/record.action/resume.html/i")
     */
    public function resumeAction()
    {
        return new Response("I'm on working now, so my resume will not open this period, sorry.");
        return $this->render('HomeBundle:Default:resume.html.twig');
    }

    /**
     * 拉勾版简历
     *
     * @Route("/record.action/resume.html/lagou")
     */
    public function lagouAction(Request $request)
    {
        if ($request->get('version') == 2) {
            return $this->render('HomeBundle:Default:lagou_v2.html.twig');
        }
        return $this->render('HomeBundle:Default:lagou.html.twig');
    }

    /**
     * PHP 的LOGO
     *
     * @Route("/image.action/logo.php")
     * @param Request $request
     * @return Response
     */
    public function logoAction(Request $request)
    {
        if($request->getHost() == 'yeskn.dev')
            $logo_path = 'https://static.yeskn.com/php-logo.svg';
        else
            $logo_path = '/alidata/www/static/php-logo.svg';

        return new Response(file_get_contents($logo_path),200,array(
            'Content-Type' => 'image/svg+xml'
        ));
    }

}
