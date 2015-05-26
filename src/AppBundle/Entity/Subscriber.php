<?php

namespace AppBundle\Entity;

use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Holds the data needed for a subscribed User
 */
class Subscriber
{
    /**
     * @DoctrineAssert\Enum(entity="AppBundle\Entity\Types\PaymentType")
     * @ORM\Column(name="pricingtype", type="PaymentType", nullable=false)
     */
    protected $_pricingtype;

    /**
     * @ORM\Column(name="school", type="string", nullable=true, length=150)
     */
    protected $_school;

    /**
     * @ORM\Column(name="graduation", type="integer", nullable=true, length=4)
     */
    protected $_graduation;

    /**
     * @ORM\OneToMany(targetEntity="Subscriptions", mappedBy="subscription")
     */
    protected $_subscriptions;

    /**
     * Get pricingtype
     *
     * @return string
     */
    public function getPricingType()
    {
        return $this->_pricingtype;
    }

    /**
     * Set name
     *
     * @param string $type
     * @return this
     */
    public function setPricingType($type)
    {
        $this->_pricingtype = $type;

        return $this;
    }

    /**
     * @return String
     */
    public function getSchool()
    {
        return $this->_school;
    }

    /**
     * @param String
     * @return this
     */
    public function setSchool($school)
    {
        $this->_school = $school;

        return $this;
    }

    /**
     * @return Integer
     */
    public function getGraduation()
    {
        return $this->_graduation;
    }

    /**
     * @param Integer
     * @return this
     */
    public function setGraduation($graduation)
    {
        $this->_graduation = $graduation;

        return $this;
    }

    /**
     * @param Subscription[] $subscriptions
     * @return this
     */
    public function setSubscriptions($subscriptions)
    {
        if(!is_array($subscriptions)){
           $subscriptions = array($subscriptions);
        }
        $this->_subscriptions = new ArrayCollection($subscriptions);

        return $this;
    }

    /**
     * @return User[] subscribers
     */
    public function getSubscriptions()
    {
        return $this->_subscriptions;
    }

    /**
     * @return boolean
     */
    public function hasPaidSubscription()
    {
        foreach ($this->_subscriptions as $subscription) {
           if($subscription->isPaid()){return true;}
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function hasActiveSubscription()
    {
        foreach ($this->_subscriptions as $subscription) {
           if($subscription->isActive()){return true;}
        }
        return false;
    }
}
