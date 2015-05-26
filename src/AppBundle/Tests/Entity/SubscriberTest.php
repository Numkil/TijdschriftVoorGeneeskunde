<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Subscriber;
use AppBundle\Entity\Subscription;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class BookstoreTest
 */
class SubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function testSubscriptionChecks()
    {
        $subscriber = new Subscriber();

        $subscriber->setSubscriptions(array($this->createSubscription1(), $this->createSubscription2()));
        $this->assertTrue($subscriber->hasActiveSubscription());
        $this->assertFalse($subscriber->hasPaidSubscription());

        $subscriber->setSubscriptions(array($this->createSubscription1(), $this->createSubscription3()));
        $this->assertTrue($subscriber->hasPaidSubscription());

        $subscriber->setSubscriptions(array($this->createSubscription2()));
        $this->assertFalse($subscriber->hasActiveSubscription());

    }

    private function createSubscription1(){
        $time = new Subscription(new \DateTime(), new \DateTime('2020-01-01'));
        return $time;
    }

    private function createSubscription2(){
        $time= new Subscription(new \DateTime('2011-01-01'), new \DateTime('2012-01-01'));
        return $time;
    }

    private function createSubscription3(){
        $time = new Subscription(new \DateTime(), new \DateTime('2020-01-01'));
        $time->setPaid(true);
        return $time;
    }


}
