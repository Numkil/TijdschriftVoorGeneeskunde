<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Subscriber;
use AppBundle\Entity\Subscription;
use AppBundle\Form\Type\SubscriberFormType;

class SubscriptionController extends Controller{

    /**
     * @Route("/subscription/{userid}/new/", name="newSubscription")
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


            $em->persist($subscription);
            if($newsubscriber){
                $em->persist($subscriber->getFacturationAddress());
                $em->persist($subscriber->getDeliveryAddress());
                $em->persist($subscriber);
            }

            $em->flush();
            $this->addFlash(
                'notice', 'subscription added'
            );
            return $this->render('FOSUserBundle::Profile/show.html.twig', array(
                'user' => $user,
            ));
        }


        return $this->render('subscription/new.html.twig', array(
            'form' => $subscriberform->createView(),
            'newsubscriber' => $newsubscriber,
        ));
    }

    /**
     * @Route("/subscription/{userid}/activate/", name="activateSubscription")
     */
    public function activateSubscriptionAction(Request $request, $userid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));

        $user->getSubscriber()->getActiveSubscription()->setPaid(true);
        $user->addRole('ROLE_PAIDUSER');
        $em->flush();

        return $this->render('FOSUserBundle::Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/subscription/{userid}/deactivate/", name="deActivateSubscription")
     */
    public function deActivateSubscriptionAction(Request $request, $userid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));

        $user->getSubscriber()->getActiveSubscription()->setPaid(false);
        $user->removeRole('ROLE_PAIDUSER');
        $em->flush();

        return $this->render('FOSUserBundle::Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/printer/", name="pagePrinter")
     */
    public function pagePrinterAction()
    {
        $count = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findCountActiveSubscribers();
        return $this->render('::printer/index.html.twig', array(
            'count' => $count,
        ));
    }

    /**
     * @Route("/printer/download/", name="pagePrinterDownload")
     */
    public function pagePrinterDownloadAction()
    {
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findActiveSubscribers();

        // ask the service for a Excel5
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("liuggio")
            ->setLastModifiedBy("TvG")
            ->setTitle("List subscribers")
            ->setSubject("List subscribers")
            ->setDescription("Generated list of the current subscribers for TvG")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Test result file");
        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A1', $this->get('translator')->trans('Name'))
            ->setCellValue('B1', $this->get('translator')->trans('Firstname'))
            ->setCellValue('C1', $this->get('translator')->trans('Street'))
            ->setCellValue('D1', $this->get('translator')->trans('Postal code'))
            ->setCellValue('E1', $this->get('translator')->trans('Municipality'))
            ->setCellValue('F1', $this->get('translator')->trans('Country'));
        for ($i = 0; $i < sizeof($users); $i++) {
            $fixedindex = $i+2;
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A'.strval($fixedindex), $users[$i]->getName())
                ->setCellValue('B'.strval($fixedindex), $users[$i]->getFirstname())
                ->setCellValue('C'.strval($fixedindex), $users[$i]->getSubscriber()->getDeliveryAddress()->getStreet())
                ->setCellValue('D'.strval($fixedindex), $users[$i]->getSubscriber()->getDeliveryAddress()->getPostalCode())
                ->setCellValue('E'.strval($fixedindex), $users[$i]->getSubscriber()->getDeliveryAddress()->getMunicipality())
                ->setCellValue('F'.strval($fixedindex), $users[$i]->getSubscriber()->getDeliveryAddress()->getCountry());
        }
        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'stream-file.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

}
