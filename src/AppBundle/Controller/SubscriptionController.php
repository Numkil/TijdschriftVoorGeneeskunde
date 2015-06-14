<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Subscriber;
use AppBundle\Entity\Subscription;
use AppBundle\Entity\Invoice;
use AppBundle\Form\Type\SubscriberFormType;
use AppBundle\Form\Type\SubscriptionFormType;
use AppBundle\Service\PdfGenerator;
use AppBundle\Entity\Types\PaymentType;

class SubscriptionController extends Controller{

    /**
     * @Route("/subscriber/{userid}/new/", name="newSubscription")
     */
    public function newSubscriptionAction(Request $request, $userid){

        $em = $this->getDoctrine()->getManager();
        $newsubscriber = false;

        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        if(!$user->getSubscriber()){
            $user->setSubscriber(new Subscriber());
            $newsubscriber = true;
        }

        $subscriber = $user->getSubscriber();

        $subscriberform = $this->createForm(new SubscriberFormType(), $subscriber);
        $subscriberform->handleRequest($request);

        if ($subscriberform->isValid())
        {
            $date = new \DateTime();
            $expire = new \DateTime();
            $expire->add(new \DateInterval('P1Y'));
            //create a new subscription with
            $subscription = new Subscription($date, $expire);
            $subscriber->addSubscription($subscription);
            $subscription->setSubscriber($subscriber);
            $user->setSubscriber($subscriber);
            $subscriber->setUser($user);
            $subscription->setPricingType($subscriber->getPricingType());

            $em->persist($subscription);
            if($newsubscriber){
                $em->persist($subscriber->getDeliveryAddress());
                $em->persist($subscriber->getFacturationAddress());
                $em->persist($subscriber);
            }

            $em->flush();
            $this->addFlash(
                'notice', $this->get('translator')->trans('Subscription added')
            );
            return $this->render('FOSUserBundle::Profile/show.html.twig', array(
                'user' => $user,
            ));
        }

        return $this->render('subscription/new.html.twig', array(
            'form' => $subscriberform->createView(),
            'newsubscriber' => $newsubscriber,
            'userid' => $userid,
        ));
    }

    /**
     * @Route("/subscriber/{userid}/edit/", name="editSubscriber")
     */
    public function editSubscriberAction(Request $request, $userid){

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $subscriber = $user->getSubscriber();

        $subscriberform = $this->createForm(new SubscriberFormType(), $subscriber);
        $subscriberform->handleRequest($request);

        if ($subscriberform->isValid())
        {
            $em->flush();
            $this->addFlash(
                'notice', $this->get('translator')->trans('Subscription information updated')
            );
            return $this->render('FOSUserBundle::Profile/show.html.twig', array(
                'user' => $user,
            ));
        }

        return $this->render('subscription/new.html.twig', array(
            'form' => $subscriberform->createView(),
            'newsubscriber' => false,
            'userid' => $userid,
        ));
    }

    /**
     * @Route("/subscriber/{userid}/suspend/", name="suspendSubscription")
     */
    public function suspendSubscriptionAction(Request $request, $userid){

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));

        $subscriber = $user->getSubscriber();

        $subscriberform = $this->createForm(new SubscriberFormType(), $subscriber);
        $subscriberform->handleRequest($request);

        if ($subscriberform->isValid())
        {
            $date = clone $subscriber->getActiveSubscription()->getEndDate();
            $expire = clone $subscriber->getActiveSubscription()->getEndDate();
            $expire->add(new \DateInterval('P1Y'));
            //create a new subscription with
            $subscription = new Subscription($date, $expire);
            $subscriber->addSubscription($subscription);
            $subscription->setSubscriber($subscriber);

            $em->persist($subscription);
            $em->flush();

            $this->addFlash(
                'notice', $this->get('translator')->trans('Your subscription has been extended')
            );

            return $this->render('FOSUserBundle::Profile/show.html.twig', array(
                'user' => $user,
            ));
        }

        return $this->render('subscription/new.html.twig', array(
            'form' => $subscriberform->createView(),
            'newsubscriber' => false,
            'userid' => $userid,
        ));
    }

    /**
     * @Route("/admin/subscription/{userid}/{subscriptionid}/activate/", name="activateSubscription")
     */
    public function activateSubscriptionAction(Request $request, $userid, $subscriptionid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $subscr = $em->getRepository('AppBundle:Subscription')
            ->findOneBy(array('id' => $subscriptionid));

        $subscr->setPaid(true);
        if($subscr->isActive()){
            $user->addRole('ROLE_PAIDUSER');
        }
        $em->flush();

        return $this->render('FOSUserBundle::Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/admin/subscription/{userid}/{subscriptionid}/deactivate/", name="deActivateSubscription")
     */
    public function deActivateSubscriptionAction(Request $request, $userid, $subscriptionid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $subscr = $em->getRepository('AppBundle:Subscription')
            ->findOneBy(array('id' => $subscriptionid));

        $subscr->setPaid(false);
        if($subscr->isActive()){
            $user->removeRole('ROLE_PAIDUSER');
        }
        $em->flush();

        return $this->render('FOSUserBundle::Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/admin/subscription/{userid}/{subscriptionid}/edit", name="editSubscription")
     */
    public function editSubscription(Request $request, $userid, $subscriptionid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $subscr = $em->getRepository('AppBundle:Subscription')
            ->findOneBy(array('id' => $subscriptionid));

        $subscriptionform = $this->createForm(new SubscriptionFormType(), $subscr);
        $subscriptionform->handleRequest($request);

        if($subscriptionform->isValid()){
            $em->flush();
            return $this->render('FOSUserBundle::Profile/show.html.twig', array(
                'user' => $user,
            ));
        }

        return $this->render('::subscription/edit.html.twig', array(
            'form' => $subscriptionform->createView(),
            'userid' => $user->getId(),
        ));

    }

    /**
     * @Route("/admin/subscription/delete/{userid}/{subscriptionid}/", name="deleteSubscription")
     */
    public function deleteSubscription(Request $request, $userid, $subscriptionid)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('DELETE FROM AppBundle:Subscription s WHERE s.id = '.$subscriptionid);
        $query->execute();

        return $this->redirectToRoute('viewSpecificUser', array( 'userid' => $userid ));

    }

    /**
     * @Route("/subscriber/{userid}/transferform/{subscriptionid}", name="getTransferForm")
     */
    public function getTransferForm(Request $request, $userid, $subscriptionid)
    {
        $em = $this->getDoctrine()->getManager();
        $system = $em->getRepository('AppBundle:System')->find(1);
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $subscription = $em->getRepository('AppBundle:Subscription')
            ->findOneBy(array('id' => $subscriptionid));
        $pdfGenerator = new PdfGenerator();
        $pdfGenerator->generateTransferForm($this->get('kernel')->getRootDir() . "/Resources/Images/",
                            PaymentType::getPrice($subscription->getPricingType()),
                            $user->getFirstName() . " " . $user->getName(),
                            $user->getSubscriber()->getFacturationAddress()->getStreet(),
                            $user->getSubscriber()->getFacturationAddress()->getPostalCode() . ' ' . $user->getSubscriber()->getFacturationAddress()->getMunicipality(),
                            $system->getIban(),
                            $system->getBic(),
                            $system->getName(),
                            $system->getStreet(),
                            $system->getPostalCode() . " " . $system->getMunicipality(),
                            substr(date('Y'), 1) . date("dm") . sprintf('%05d', $user->getSubscriber()->getId()));
        exit();

    }

    /**
     * @Route("/subscriber/{userid}/invoice/{subscriptionid}/{ordernumber}", name="createSubscriptionInvoice", defaults={"ordernumber" = ""})
     */
    public function createInvoice(Request $request, $userid, $subscriptionid, $ordernumber){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $subscription = $this->getDoctrine()->getRepository('AppBundle:Subscription')->findOneBy(array('id' => $subscriptionid));
        if($subscription->getSubscriber()->getVatNumber() == null){
            $this->addFlash(
                'error',
                'You have to set your vat number before you can generate an invoice, please edit your subscription to add it!'
            );
            return $this->render('FOSUserBundle::Profile/show.html.twig', array('user' => $user));
        }

        $invoiceNumber = $this->getDoctrine()->getRepository('AppBundle:System')->getInvoiceNumber();
        $em = $this->getDoctrine()->getManager();

        //var_dump($user->getFirstName() . " " . $user->getName());

        $invoice = new Invoice();
        $invoice->setDate(new \DateTime());
        $invoice->setName($user->getFirstName() . " " . $user->getName());
        $invoice->setStreet($user->getSubscriber()->getFacturationAddress()->getStreet());
        $invoice->setPostalCode($user->getSubscriber()->getFacturationAddress()->getPostalCode());
        $invoice->setMunicipality($user->getSubscriber()->getFacturationAddress()->getMunicipality());
        $invoice->setVatNumber($user->getSubscriber()->getVatNumber());
        $invoice->setOrderNumber($ordernumber);
        $invoice->setInvoiceNumber(date('Y') . '-' . strval($invoiceNumber));
        $invoice->setSubscription($subscription);
        $invoice->setPrice(PaymentType::getPrice($subscription->getPricingType()));
        $invoice->setDiscount(PaymentType::getDiscount($subscription->getPricingType()));
        $invoice->setOgm(substr(date('Y'), 1) . sprintf('%04d', $invoiceNumber) . sprintf('%05d', $user->getSubscriber()->getId()));

        $em->persist($invoice);
        $subscription->addInvoice($invoice);
        $em->flush();
        $this->getDoctrine()->getRepository('AppBundle:System')->incrementInvoiceNumber();

        $pdfGenerator = new PdfGenerator();
        $pdfGenerator->generateInvoicePdf($invoice);
        exit();
    }

    /**
     * @Route("/invoice/{invoiceid}/", name="getInvoice")
     */
    public function getInvoice(Request $request, $invoiceid){
        $invoice = $this->getDoctrine()->getRepository('AppBundle:Invoice')->find($invoiceid);

        $pdfGenerator = new PdfGenerator();
        $pdfGenerator->generateInvoicePdf($invoice);
        exit();
    }

    /**
     * @Route("/subscription/{subscriptionid}/invoices/", name="subscriptionInvoiceOverview")
     */
    public function indexAction(Request $request, $subscriptionid){
        $invoices = $this->getDoctrine()
            ->getRepository('AppBundle:Invoice')->findBy(array('_subscription' => $subscriptionid), array('_invoiceNumber' => 'ASC'));

        return $this->render('invoice/index.html.twig', array('invoices' => $invoices));
    }
}
