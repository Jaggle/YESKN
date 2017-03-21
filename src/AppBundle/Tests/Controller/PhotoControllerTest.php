<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/5/19
 * Time: 23:44
 */

namespace AppBundle\Tests\Controller;


use AppBundle\Controller\PhotoController;

class PhotoControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testFile()
    {
        $calc = new PhotoController();
        $result = $calc->add(30, 12);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}
