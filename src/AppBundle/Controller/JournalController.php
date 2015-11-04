<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class JournalController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("AppBundle:Journal:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/journal/add", name="add_journal")
     * @Template("AppBundle:Journal:add.html.twig")
     */
    public function addAction(Request $request){

        return [];
    }
}