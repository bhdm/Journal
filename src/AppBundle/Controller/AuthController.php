<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\ProfileType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class AuthController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(){

        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        return array(
            'error' => $error
        );
    }

    /**
     * @Route("/profile", name="profile")
     * @Template()
     */
    public function profileAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:User')->findOneById($this->getUser());
        $form = $this->createForm(new ProfileType($em), $item);
        $formData = $form->handleRequest($request);
        if ($formData->isValid()){
            $item = $formData->getData();
            $em->persist($item);
            $em->flush();
            $em->refresh($item);
            return $this->redirect($this->generateUrl('journal_list'));
        }

        return ['form' => $form->createView(), 'journal' => $item];
    }

    /**
     * @Route("/setuser", name="setUser")
     * @Template()
     */
    public function setUserAction(){
        $em = $this->getDoctrine()->getManager();
        for ( $i = 1 ; $i <= 128 ; $i ++){
            if ($i < 10 ){
                $pass = 'BLS2014MS000';
                $login = 'EJIM05780-000';
            }elseif($i < 100){
                $pass = 'BLS2014MS00';
                $login = 'EJIM05780-00';
            }else{
                $pass = 'BLS2014MS0';
                $login = 'EJIM05780-0';
            }
            $user = new User();
            $user->setUsername($login.$i);
            $user->setPassword($pass.$i);
            $user->setRoles('ROLE_USER');
            $user->setSalt(0);
            $em->persist($user);
            $em->flush($user);
        }
    }

}
