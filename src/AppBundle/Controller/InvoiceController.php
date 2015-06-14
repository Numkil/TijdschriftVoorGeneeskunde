<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Invoice;
use AppBundle\Service\PdfGenerator;


/**
* class InvoiceController
*/
class InvoiceController extends Controller{

    /**
     * @Route("/invoice/{invoiceid}/", name="getInvoice")
     */
    public function getInvoice(Request $request, $invoiceid){
        $invoice = $this->getDoctrine()->getRepository('AppBundle:Invoice')->find($invoiceid);

        $pdfGenerator = new PdfGenerator();
        $pdfGenerator->generateInvoicePdf($invoice);
        exit();
    }

}
