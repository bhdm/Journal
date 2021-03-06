<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * @Route("/journal/{journalId}/posts", name="post_list")
     * @Template("AppBundle:Post:index.html.twig")
     */
    public function indexAction(Request $request,$journalId)
    {
        $journal = $this->getDoctrine()->getRepository('AppBundle:Journal')->findOneBy(['id'=> $journalId, 'enabled' => true]);
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findBy(['journal' => $journal, 'enabled' => true]);
        return array( 'journal'=> $journal, 'posts' => $posts );
    }

    /**
     * @Route("/journal/{journalId}/post/add", name="post_add")
     * @Template("AppBundle:Post:add.html.twig")$item->
     */
    public function addAction(Request $request, $journalId){
        $em = $this->getDoctrine()->getManager();
        $journal = $this->getDoctrine()->getRepository('AppBundle:Journal')->findOneBy(['id'=> $journalId]);
        $item = new Post();
        $form = $this->createForm(new PostType($em), $item);
        $formData = $form->handleRequest($request);
        if ($formData->isValid()){
            $item = $formData->getData();
            $item->setJournal($journal);

            $em->persist($item);
            $em->flush();
            $em->refresh($item);
            return $this->redirect($this->generateUrl('post_list', ['journalId' => $journalId]));
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/journal/{journalId}/post/{id}/edit", name="post_edit")
     * @Template("AppBundle:Post:edit.html.twig")
     */
    public function editAction(Request $request, $journalId, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Post')->findOneById($id);
        $form = $this->createForm(new PostType($em), $item);
        $formData = $form->handleRequest($request);
        if ($formData->isValid()){
            $item = $formData->getData();
            $em->persist($item);
            $em->flush();
            $em->refresh($item);
            return $this->redirect($this->generateUrl('post_list', ['journalId' => $journalId]));
        }

        return ['form' => $form->createView(), 'post' => $item];
    }

    /**
     * @Route("/journal/{journalId}/post/{id}/remove", name="post_remove")
     */
    public function removeAction(Request $request, $journalId, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Post')->findOneById($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('post_list', ['journalId' => $journalId]));
    }

    /**
     * @Route("/journal/{journalId}/post/{id}/show/{type}", name="post_show", defaults={ "type" = null })
     * @Template("AppBundle:Post:show.html.twig")
     */
    public function showAction($journalId, $id, $type = null){
        $journal = $this->getDoctrine()->getRepository('AppBundle:Journal')->findOneBy(['id'=> $journalId, 'enabled' => true]);
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findOneBy(['journal' => $journal, 'enabled' => true, 'id' => $id]);
        if ($type === 'pdf-ru' || $type === 'pdf-en'){

            $mpdfService = $this->container->get('tfox.mpdfport');
            $arguments = array(
//            'constructorArgs' => array('utf-8', 'A4', 0 ,0 ,0 ,0, 0 ), //Constructor arguments. Numeric array. Don't forget about points 2 and 3 in Warning section!
                'writeHtmlMode' => null, //$mode argument for WriteHTML method
                'writeHtmlInitialise' => null, //$mode argument for WriteHTML method
                'writeHtmlClose' => null, //$close argument for WriteHTML method
                'outputFilename' => null, //$filename argument for Output method
                'outputDest' => null, //$dest argument for Output method
            );
            $mpdfService->ignore_invalid_utf8 = true;
            $mpdfService->allow_charset_conversion = false;
            $mpdfService->debug = true;
            $html = $this->renderView('AppBundle:Post:show_mini.html.twig',['journal'=> $journal, 'post' => $post , 'type' => $type]);

            return $mpdfService->generatePdfResponse($html, $arguments);

        }
        return array( 'journal'=> $journal, 'post' => $post , 'type' => $type );
    }
}