<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Bookstore
 */
class Bookstore
{

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="subscriber")
     */
    protected $_subscribers;

    /**
     * @param User[] $subscribers
     * @return this
     */
    public function setSubscribers($subscribers)
    {
        if(!is_array($subscribers)){
           $subscribers = array($subscribers);
        }
        $this->_subscribers = new ArrayCollection($subscribers);

        return $this;
    }

    /**
     * @return User[] subscribers
     */
    public function getSubscribers()
    {
        return $this->_subscribers;
    }

    /**
     * Add one user to subscribers
     * @param User $subscriber
     * @return this
     */
    public function addSubscriber($subscriber)
    {
        if(!$this->_subscribers->contains($subscriber)){
            $this->_subscribers->add($subscriber);
        }
        return $this;
    }

    /**
     * Remove one user from subscribers
     * @param User $subscriber
     * @return User $subscribed
     */
    public function removeSubscriber($subscriber)
    {
        $subscribed = $this->_subscribers->removeElement($subscriber);

        return $subscribed;
    }

    /**
     * Get size of subscribers
     * @return integer $size
     */
    public function amountSubscribers()
    {
        return $this->_subscribers->count();
    }
}
