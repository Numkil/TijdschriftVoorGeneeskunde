<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Document;

class MediaController extends Controller{
    /**
     * @Route("/admin/upload/{userid}", name="uploadDocument")
     */
    public function uploadAction(Request $request)
    {
        $document = new Document();
        $form = $this->createFormBuilder($document)
            ->add('name')
            ->add('file')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $document->upload();

            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute('viewSpecificUser', array( 'userid' => $userid ));

        }

        return array('form' => $form->createView());
    }

}
