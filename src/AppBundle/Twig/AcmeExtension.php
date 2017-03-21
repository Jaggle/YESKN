<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/5/18
 * Time: 23:02
 */

namespace AppBundle\Twig;


class AcmeExtension extends \Twig_Extension
{
    public function sayWhatYouSay()
    {
        return "say what you say ?";
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('say_what_you_say', array($this, 'sayWhatYouSay'), array('is_safe' => array('html'), 'needs_environment' => true))
        );
    }

    public function getName()
    {
        return 'acme_extension';
    }
}