<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PageContent;
use AppBundle\Form\Type\PageContentFormType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:PageContent')->findOneBy(array('_url' => '/'));
        if(!$content){
            $content = new PageContent('/', '');
            $em->persist($content);
            $em->flush();
        }
        $form = null;

        if($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')){
            $form = $this->createForm(new PageContentFormType(), $content);
            $form->handleRequest($request);
            if($form->isValid()){
                $em->flush();
            }
        }

        return $this->render('default/index.html.twig', array(
            'form' => $form ? $form->createView() : null,
            'content' => $content,
        ));
    }

    /**
     * @Route("/contact/", name="contact")
     */
    public function contactAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:PageContent')->findOneBy(array('_url' => '/contact/'));
        if(!$content){
            $content = new PageContent('/contact/', '');
            $em->persist($content);
            $em->flush();
        }
        $form = null;

        if($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')){
            $form = $this->createForm(new PageContentFormType(), $content);
            $form->handleRequest($request);
            if($form->isValid()){
                $em->flush();
            }
        }

        return $this->render('default/contact.html.twig', array(
            'form' => $form ? $form->createView() : null,
            'content' => $content,
        ));
    }

    /**
     * @Route("/editors/", name="editors")
     */
    public function editorAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('AppBundle:PageContent')->findOneBy(array('_url' => '/editors/'));
        if(!$content){
            $content = new PageContent('/editors/', '');
            $em->persist($content);
            $em->flush();
        }
        $form = null;

        if($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')){
            $form = $this->createForm(new PageContentFormType(), $content);
            $form->handleRequest($request);
            if($form->isValid()){
                $em->flush();
            }
        }

        return $this->render('default/editors.html.twig', array(
            'form' => $form ? $form->createView() : null,
            'content' => $content,
        ));
    }

}
