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

            $date = new \DateTime();
            //create a new subscription with
            $subscription = new Subscription($date, $date->add(new \DateInterval('P1Y')));
            $subscriber->addSubscription($subscription);
            $subscription->setSubscriber($subscriber);
            $user->setSubscriber($subscriber);
            $subscriber->setUser($user);

            $em->persist($subscription);
            $em->persist($subscriber->getFacturationAddress());
            $em->persist($subscriber->getDeliveryAddress());
            $em->persist($subscriber);

            $em->flush();
            $this->addFlash(
               'notice', 'subscription added'
            );
            return $this->redirectToRoute('homepage');
        }


        return $this->render('subscription/new.html.twig', array(
            'form' => $subscriberform->createView(),
            'newsubscriber' => $newsubscriber,
        ));
    }

}
