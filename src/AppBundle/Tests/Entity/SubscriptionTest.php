<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Subscription;

/**
 * Class BookstoreTest
 */
class SubscriptionTest extends \PHPUnit_Framework_TestCase
{
    public function testSubscriptionIsActive()
    {
        // Arrange
        $subscription = $this->createActiveSubscription();

        // Assert
        $this->assertTrue($subscription->isActive());

    }

    private function createActiveSubscription(){
        $subscription = new Subscription(new \DateTime(), new \DateTime('today +1 year'));
        $subscription->setPaid(true);
        return $subscription;
    }


}