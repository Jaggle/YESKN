<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/10/15
 * Time: 13:28
 */

namespace AppBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
	private $debug;
	private $twig;

	public function __construct(ContainerInterface $container, \Twig_Environment $twig)
	{
		$this->debug = $container->getParameter('kernel.debug');
		$this->twig = $twig;
	}

	public function onKernelException(GetResponseForExceptionEvent $event)
	{
		//不是不是debug，则显示定制页面
		if (!$this->debug) {
			
			$response = new Response($this->twig->render(':Exceptions:default.html.twig', [
				'message'  => $event->getException()->getMessage()
			]));
			$event->setResponse($response);

		}
	}
}