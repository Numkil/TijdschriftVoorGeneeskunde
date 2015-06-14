<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\HealthcareFormType;
use AppBundle\Entity\HealthCare;
use AppBundle\Entity\Invoice;
use AppBundle\Entity\Types\PaymentType;
use AppBundle\Service\PdfGenerator;

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
     * @Route("/healthcare/details/{id}", name="healthcareDetails")
     */
    public function detailsAction(Request $request, $id){
        $healthcare = $this->getDoctrine()->getRepository('AppBundle:Healthcare')->find($id);

        return $this->render('healthcare/details.html.twig', array('healthcare' => $healthcare));
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

    /**
     * @Route("/healthcare/{id}/invoice/{ordernumber}", name="createHealthcareInvoice", defaults={"ordernumber" = ""})
     */
    public function createInvoice(Request $request, $id, $ordernumber){
        $healthcare = $this->getDoctrine()->getRepository('AppBundle:Healthcare')->find($id);
        $invoiceNumber = $this->getDoctrine()->getRepository('AppBundle:System')->getInvoiceNumber();
        $em = $this->getDoctrine()->getManager();

        //var_dump($user->getFirstName() . " " . $user->getName());

        $invoice = new Invoice();
        $invoice->setDate(new \DateTime());
        $invoice->setName($healthcare->getName());
        $invoice->setStreet($healthcare->getAddress()->getStreet());
        $invoice->setPostalCode($healthcare->getAddress()->getPostalCode());
        $invoice->setMunicipality($healthcare->getAddress()->getMunicipality());
        $invoice->setVatNumber($healthcare->getVatNumber());
        $invoice->setOrderNumber($ordernumber);
        $invoice->setInvoiceNumber(date('Y') . '-' . strval($invoiceNumber));
        $invoice->setHealthcare($healthcare);
        $invoice->setPrice(PaymentType::getPrice(PaymentType::HEALTHCARE_PRICE));
        $invoice->setDiscount(PaymentType::getDiscount(PaymentType::HEALTHCARE_PRICE));

        $invoice->setSubscriberNumbers($healthcare->getUnpaidSubscriberNumbers());

        $invoice->setOgm(substr(date('Y'), 1) . sprintf('%04d', $invoiceNumber) . sprintf('%05d', $healthcare->getId()));

        $em->persist($invoice);
        $healthcare->addInvoice($invoice);
        $em->flush();
        $this->getDoctrine()->getRepository('AppBundle:System')->incrementInvoiceNumber();

        $pdfGenerator = new PdfGenerator();
        $pdfGenerator->generateInvoicePdf($invoice);
        exit();
    }

    /**
     * @Route("/healthcare/{id}/invoices/", name="healthcareInvoiceOverview")
     */
    public function invoiceIndexAction(Request $request, $id){
        $invoices = $this->getDoctrine()
            ->getRepository('AppBundle:Invoice')->findBy(array('_healthcare' => $id), array('_invoiceNumber' => 'ASC'));

        return $this->render('invoice/index.html.twig', array('invoices' => $invoices));
    }
}
