<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\HealthcareFormType;
use AppBundle\Entity\HealthCare;

class HealthcareController extends Controller
{
	/**
     * @Route("/healthcare/", name="healthcareOverview")
     */
    public function indexAction(Request $request){
        $organisations = $this->getDoctrine()
            ->getRepository('AppBundle:HealthCare')->findAll();

        return $this->render('healthcare/index.html.twig', array('healthcares' => $organisations));
    }

    /**
     * @Route("/healthcare/new/", name="createHealthcare")
     */
    public function createHealthcareAction(Request $request){
        $healthCareObject = new HealthCare();

        $form = $this->createForm(new HealthcareFormType(), $healthCareObject);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //Have to add address object to database before it can be used as a foreign key in the bookstoreObject
            $em->persist($healthCareObject->getAddress());
            $em->persist($healthCareObject);
            $em->flush();

            return $this->redirectToRoute('healthcareOverviewOverview');
        }

        $parameters = array(
            "form" => $form->createView(),
        );

        return $this->render('healthcare/new.html.twig', $parameters);
    }

    /**
     * @Route("/healthcare/update/{id}", name="updateHealthcare")
     */
    public function updateHealthcareAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $healthcare = $em->getRepository('AppBundle:HealthCare')->find($id);

        if (!$healthcare) {
            throw $this->createNotFoundException(
                'No healthcare found for id '.$id
            );
        }

        $form = $this->createForm(new HealthcareFormType(), $healthcare);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('healthcareOverview');
        }

        $parameters = array(
            'form' => $form->createView(),
            'healthcareID' => $healthcare->getId(),
        );

        return $this->render('healthcare/new.html.twig', $parameters);
    }

    /**
     * @Route("/healthcare/remove/{id}", name="removeHealthcare")
     */
    public function removeHealthcareAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $healthcare = $em->getRepository('AppBundle:HealthCare')->find($id);
        $em->remove($healthcare);
        $em->flush();

        return $this->redirectToRoute('healthcareOverview');
    }
}
