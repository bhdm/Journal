<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(){
        return [];
    }
}
