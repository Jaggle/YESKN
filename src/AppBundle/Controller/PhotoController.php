<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * 相册展示
 *
 * Class PhotoController
 * @package AppBundle\Controller
 * @Route("/photo")
 */
class PhotoController extends Controller
{

    /**
     * @return Response
     * @Route("/" , name="photo_index")
     */
    public function indexAction()
    {
        $photos = $this->getDoctrine()->getRepository("AppBundle:Photo")->findAll();

	    return $this->render('photo/show.html.twig', array(
            'photos' => $photos
	    ));
    }

    /**
     * @return Response
     * @Route("/acme", name="photo_acme")
     */
    public function AcmeAction(Request $request)
    {
        return new Response($request->isXhrRequest());
    }
}
