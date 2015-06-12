<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\SystemFormType;
use AppBundle\Entity\System;

class SystemController extends Controller{

	/**
     * @Route("/admin/system/update/", name="updateSystem")
     */
    public function updateSytemAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $system = $em->getRepository('AppBundle:System')->find(1);
        $form = $this->createForm(new SystemFormType(), $system);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('updateSystem');
        }

        $parameters = array(
            'form' => $form->createView(),
        );

        return $this->render('system/updateSystem.html.twig', $parameters);
    }
}