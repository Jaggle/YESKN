<?php

namespace AppBundle\Controller;


use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\Model\ChangePassword;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @Route("/user")
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
	
	/**
	 * @Route("/reset_password",name="user_reset_password")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function resetPassword(Request $request)
    {
        if($this->getUser() === null){
            throw $this->createAccessDeniedException('you should login first');
        }

        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(new ChangePasswordType(),$changePasswordModel);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $hash = $this->get('security.password_encoder')->encodePassword($user,$form->getData()->newPassword);
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($hash);
            $em->flush();
            if($this->get('security.password_encoder')->isPasswordValid($user,$form->getData()->newPassword)){
                $this->addFlash('success','change password success');
                return $this->redirectToRoute('user_reset_password');
            }
        }
        return $this->render('user/reset_password.html.twig',array(
            'form' => $form->createView()
        ));
    }
}
