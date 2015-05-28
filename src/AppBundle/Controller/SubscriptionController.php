<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Subscriber;
use AppBundle\Entity\Subscription;
use AppBundle\Form\Type\SubscriberFormType;

class SubscriptionController extends Controller{

    /**
     * @Route("/subscription/{userid}/new", name="newSubscription")
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
            if($newsubscriber){
                $em->persist($subscriber);
            }

            $date = \DateTime();
            $subscription = new Subscription($date, $date->add(\DateInterval('1Y')));
            $em->persist($subscription);

            $subscriber->addSubscription($subscription);
            $em->flush();
        }


        return $this->render('subscription/new.html.twig', array(
            'form' => $subscriberform->createView(),
            'newsubscriber' => $newsubscriber,
        ));
    }

}
