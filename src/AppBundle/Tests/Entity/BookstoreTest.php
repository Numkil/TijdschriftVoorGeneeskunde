<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Bookstore;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class BookstoreTest
 */
class BookstoreTest extends \PHPUnit_Framework_TestCase
{
    public function testAddSubscriber()
    {
        $user = $this->createUser1();
        $user2 = $this->createUser2();
        $bookstore = new Bookstore();
        $bookstore->setSubscribers(array($user2));
        $bookstore->addSubscriber($user);
        $testArray = array($user2, $user);
        $this->assertEquals($testArray, $bookstore->getSubscribers()->toArray());
    }

    public function testRemoveSubscriber()
    {
        $user = $this->createUser1();
        $user2 = $this->createUser2();
        $bookstore = new Bookstore();
        $bookstore->setSubscribers(array($user, $user2));
        $bookstore->removeSubscriber($user2);
        $testArray = array($user);
        $this->assertEquals($testArray, $bookstore->getSubscribers()->toArray());
    }

    /**
     * @depends testAddSubscriber
     * @depends testRemoveSubscriber
     */
    public function testAmountSubscribers()
    {
        $user = $this->createUser1();
        $bookstore = new Bookstore();
        $bookstore->setSubscribers(array($user));
        $this->assertEquals($bookstore->amountSubscribers(), 1);
        $bookstore->removeSubscriber($user);
        $this->assertEquals($bookstore->amountSubscribers(), 0);
        $bookstore->addSubscriber($user);
        $this->assertEquals($bookstore->amountSubscribers(), 1);
        $bookstore->addSubscriber($user);
        $this->assertEquals($bookstore->amountSubscribers(), 1);
    }

    private function createUser1(){
        $user = new User();
        $user->setName('lol');
        $user->setFirstName('lal');
        return $user;
    }

    private function createUser2(){
        $user = new User();
        $user->setName('hey');
        $user->setFirstName('hoy');
        return $user;
    }

}
