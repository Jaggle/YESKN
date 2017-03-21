<?php


namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Photo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PhotoController
 * @package AppBundle\Controller\Admin
 * @Route("/admin/photo")
 */
class PhotoController extends Controller
{
	
	/**
	 * 上传图片
	 * 
	 * @Route("/upload",name="admin_photo_upload")
	 * @Method({"GET","POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function uploadAction(Request $request)
	{
		$em    = $this->getDoctrine()->getManager();
		$photo = new Photo();
		
		$author = $em->getRepository('AppBundle:User')->find($this->getUser()->getId());
		$photo->setAuthor($author);
		$form = $this->createFormBuilder()
			->add('path', FileType::class, array('label' => 'photo'))
			->add('name', TextType::class)
			->getForm()
		;
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			/**
			 * @var File $file
			 */
			$file     = $form->getData()['path'];
			$fileName = md5(uniqid()) . '.' . $file->guessExtension();

			$photoDir = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/photos';

			$file->move($photoDir, $fileName);
			
			$photo->setPath($fileName);
			$photo->setName($form->getData()['name']);
			
			$em->persist($photo);

			$em->flush();
			$this->addFlash('success', 'upload succeed');
			$this->redirectToRoute('admin_photo_upload');
		}
		
		return $this->render('admin/photo/upload.html.twig', array(
			'form' => $form->createView(),
		));
	}
	
	/**
	 * 删除图片
	 * 
	 * @Route("/delete/{id}", requirements={"id": "\d+"},name="admin_photo_delete")
	 * 
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function deleteAction($id)
	{
		$em    = $this->getDoctrine()->getManager();
		$photo = $em->getRepository('AppBundle:Photo')->find($id);
		$em->remove($photo);
		
		$fs       = new Filesystem();
		$photoDir = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/photos';
		$fs->remove($photoDir . '/' . $photo->getPath());
		
		$em->flush();
		$this->addFlash('success', 'delete a photo with id ' . $id);
		return $this->redirectToRoute('photo_index');
	}
	
	
}