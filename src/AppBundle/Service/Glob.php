<?php


namespace AppBundle\Service;

use AppBundle\Entity\Post;
use Symfony\Bridge\Doctrine\RegistryInterface as Doctrine;

class Glob
{
	/**
	 * @var Doctrine
	 */
    private $doctrine;
	
	/**
	 * @var Post
	 */
    public $post;
	
	/**
	 * Glob constructor.
	 * @param Doctrine $doc
	 */
    public function __construct(Doctrine $doc)
    {
        $this->doctrine = $doc;

    }
	
	/**
	 * @return \AppBundle\Entity\Post
	 */
	public function getOne()
    {
        $post = $this->doctrine->getRepository('AppBundle:Post')->find(1);
        return $post;
    }
}