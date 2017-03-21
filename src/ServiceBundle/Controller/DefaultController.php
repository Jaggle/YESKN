<?php

namespace ServiceBundle\Controller;

use Intervention\Image\AbstractFont;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Intervention\Image\ImageManager;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ServiceBundle:Default:index.html.twig');
    }

	/**
	 * @Route("/ip")
	 * @param Request $request
	 * @return Response
	 */
    public function ipAction(Request $request)
    {
        return new Response($request->getClientIp());
    }

    /**
     * @Route("/commits")
     */
    public function randomCommitAction()
    {

        $ch = curl_init("http://whatthecommit.com/index.txt");

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //curl_setopt($ch, CURLOPT_HEADER, 0);

        $result = curl_exec($ch);

        curl_close($ch);
        return new Response($result);
    }

    /**
     * @Route("/images")
     * @author Jake
     */
    public function imagesAction()
    {
        $image = new ImageManager();

        function randColor(){
            $color = [];
            for ($i=0;$i<6;$i++){
                $color[] = base_convert(mt_rand(0,15),10,16);
            }
            $color = '#'.implode('',$color);
            return $color;
        }

        $img = $image->canvas(250, 250, randColor());

        $img->text('Caihong 520',50,125,function(AbstractFont $font){
            $font->file($this->getParameter('kernel.root_dir').'/../web/fonts/lato/Lato-Regular.woff');
            $font->size(24);
            $font->color('#fff');
        });
        //$img->fill($img2,100,100);
        $res =  $img->encode('png');
        $headers = array(
            'Content-Type'     => 'image/png',
        );
        return new Response($res,200,$headers);

    }

    /**
     * @Route("/test")
     */
    public function test()
    {
        return new Response($this->get('kernel')->getRootDir());
    }
}
