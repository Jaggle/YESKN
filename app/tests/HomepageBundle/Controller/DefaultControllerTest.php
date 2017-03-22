<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/14
 * Time: 9:52
 */

namespace tests\HomeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testIndex()
	{
		$client = static::createClient();

		$client->request('GET', '/');

		echo $client->getResponse()->getContent();

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}
}
