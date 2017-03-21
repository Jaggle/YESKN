<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/10/15
 * Time: 14:44
 */

namespace AppBundle\EventListener;


use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener
{
	public function onKernelResponse(FilterResponseEvent $event)
	{
		
		//so nothing now
	}
}