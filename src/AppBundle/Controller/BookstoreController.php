<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\BookstoreFormType;
use AppBundle\Entity\Bookstore;
use AppBundle\Entity\Invoice;
use AppBundle\Entity\Types\PaymentType;
use AppBundle\Service\PdfGenerator;

class BookstoreController extends Controller
{
	/**
     * @Route("/bookstore/", name="bookstoreOverview")
     */
    public function indexAction(Request $request){
        $books = $this->getDoctrine()
            ->getRepository('AppBundle:Bookstore')->findAll();

        return $this->render('bookstore/index.html.twig', array('bookstores' => $books));
    }

    /**
     * @Route("/bookstore/new/", name="createBookstore")
     */
    public function createBookstoreAction(Request $request){
        $bookstoreObject = new Bookstore();

        $form = $this->createForm(new BookstoreFormType(), $bookstoreObject);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //Have to add address object to database before it can be used as a foreign key in the bookstoreObject
            $em->persist($bookstoreObject->getAddress());
            $em->persist($bookstoreObject);
            $em->flush();

            return $this->redirectToRoute('bookstoreOverview');
        }

        $parameters = array(
            "bookstore" => $form->createView(),
        );

        return $this->render('bookstore/new.html.twig', $parameters);
    }

    /**
     * @Route("/bookstore/details/{id}", name="bookstoreDetails")
     */
    public function detailsAction(Request $request, $id){
        $bookstore = $this->getDoctrine()->getRepository('AppBundle:Bookstore')->find($id);

        return $this->render('bookstore/details.html.twig', array('bookstore' => $bookstore));
    }

    /**
     * @Route("/bookstore/update/{id}", name="updateBookstore")
     */
    public function updateBookstoreAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $bookstore = $em->getRepository('AppBundle:Bookstore')->find($id);

        if (!$bookstore) {
            throw $this->createNotFoundException(
                'No bookstore found for id '.$id
            );
        }

        $form = $this->createForm(new BookstoreFormType(), $bookstore);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('bookstoreOverview');
        }

        $parameters = array(
            'bookstore' => $form->createView(),
            'bookstoreID' => $bookstore->getId(),
        );

        return $this->render('bookstore/new.html.twig', $parameters);
    }

    /**
     * @Route("/bookstore/remove/{id}", name="removeBookstore")
     */
    public function removeBookstoreAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $bookstore = $em->getRepository('AppBundle:Bookstore')->findOneById($id);
        $em->remove($bookstore);
        $em->flush();

        return $this->redirectToRoute('bookstoreOverview');
    }

    /**
     * @Route("/bookstore/{id}/invoice/{ordernumber}", name="createBookstoreInvoice", defaults={"ordernumber" = ""})
     */
    public function createInvoice(Request $request, $id, $ordernumber){
        $bookstore = $this->getDoctrine()->getRepository('AppBundle:Bookstore')->find($id);

        if($bookstore->getVatNumber() == null){
            $this->addFlash(
                'error',
                'You have to set your vat number before you can generate an invoice, please edit your subscription to add it!'
            );
            return $this->render('bookstore/details.html.twig', array('bookstore' => $bookstore));
        }

        $invoiceNumber = $this->getDoctrine()->getRepository('AppBundle:System')->getInvoiceNumber();
        $em = $this->getDoctrine()->getManager();

        //var_dump($user->getFirstName() . " " . $user->getName());

        $invoice = new Invoice();
        $invoice->setDate(new \DateTime());
        $invoice->setName($bookstore->getName());
        $invoice->setStreet($bookstore->getAddress()->getStreet());
        $invoice->setPostalCode($bookstore->getAddress()->getPostalCode());
        $invoice->setMunicipality($bookstore->getAddress()->getMunicipality());
        $invoice->setVatNumber($bookstore->getVatNumber());
        $invoice->setOrderNumber($ordernumber);
        $invoice->setInvoiceNumber(date('Y') . '-' . strval($invoiceNumber));
        $invoice->setBookstore($bookstore);
        $invoice->setPrice(PaymentType::getPrice(PaymentType::BOOKSTORE_PRICE));
        $invoice->setDiscount(PaymentType::getDiscount(PaymentType::BOOKSTORE_PRICE));

        $invoice->setSubscriberNumbers($bookstore->getUnpaidSubscriberNumbers());

        $invoice->setOgm(substr(date('Y'), 1) . sprintf('%04d', $invoiceNumber) . sprintf('%05d', $bookstore->getId()));

        $em->persist($invoice);
        $bookstore->addInvoice($invoice);
        $em->flush();
        $this->getDoctrine()->getRepository('AppBundle:System')->incrementInvoiceNumber();

        $pdfGenerator = new PdfGenerator();
        $pdfGenerator->generateInvoicePdf($invoice);
        exit();
    }

    /**
     * @Route("/bookstore/{id}/invoices/", name="bookstoreInvoiceOverview")
     */
    public function invoiceIndexAction(Request $request, $id){
        $invoices = $this->getDoctrine()
            ->getRepository('AppBundle:Invoice')->findBy(array('_bookstore' => $id), array('_invoiceNumber' => 'ASC'));

        return $this->render('invoice/index.html.twig', array('invoices' => $invoices));
    }
}
