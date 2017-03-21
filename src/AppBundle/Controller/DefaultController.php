<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	/**
	 * @Route("/index2/", name="homepage")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/index/dtest", name="app_test")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function test2Action()
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getparameter('kernerl.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }

	/**
	*
	* @Route("/index/test", name="a_test")
	* @return \Symfony\Component\HttpFoundation\Response
	*
	*/
	public function test3Action()
	{
		return $this->render('default/index.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
		]);
	}
}
