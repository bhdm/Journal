<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Journal;
use AppBundle\Form\JournalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class JournalController extends Controller
{
    /**
     * @Route("/", name="journal_list")
     * @Template("AppBundle:Journal:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $journals = $this->getDoctrine()->getRepository('AppBundle:Journal')->findBy( ['enabled' => true]);
        return array('journals' => $journals);
    }

    /**
     * @Route("/journal/add", name="journal_add")
     * @Template("AppBundle:Journal:add.html.twig")$item->
     */
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = new Journal();
        $form = $this->createForm(new JournalType($em), $item);
        $formData = $form->handleRequest($request);
        if ($formData->isValid()){
            $item = $formData->getData();

            $file = $item->getPhoto();
            $fileName = time().'.'.$file->guessExtension();
            $brochuresDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads';
            $file->move($brochuresDir, $fileName);
            $item->setPhoto($fileName);

            $em->persist($item);
            $em->flush();
            $em->refresh($item);
            return $this->redirect($this->generateUrl('journal_list'));
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/journal/{id}/edit", name="journal_edit")
     * @Template("AppBundle:Journal:edit.html.twig")
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Journal')->findOneById($id);
        $form = $this->createForm(new JournalType($em), $item);
        $formData = $form->handleRequest($request);
        if ($formData->isValid()){
            $item = $formData->getData();

            $file = $item->getPhoto();
            $fileName = time().'.'.$file->guessExtension();
            $brochuresDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/uploads';
            $file->move($brochuresDir, $fileName);
            $item->getPhoto($fileName);

            $em->persist($item);
            $em->flush();
            $em->refresh($item);
            return $this->redirect($this->generateUrl('journal_list'));
        }

        return ['form' => $form->createView(), 'journal' => $item];
    }

    /**
     * @Route("/journal/{id}/remove", name="journal_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Journal')->findOneById($id);
        if ($item){
            if (is_file(__DIR__.'/../../../../web/uploads/'.$item->getPhoto())){
                unlink(__DIR__.'/../../../../web/uploads/'.$item->getPhoto());
            }
            foreach ($item->getPosts() as $p){
                $em->remove($p);
                $em->flush();
            }
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('journal_list'));
    }
}