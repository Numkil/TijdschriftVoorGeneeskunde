<?php

namespace AppBundle\Entity;

use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Holds the data needed for a subscribed User
 * @ORM\Entity
 * @ORM\Table(name="subscriber")
 */
class Subscriber
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @ORM\Column(name="graduation", type="datetime", nullable=true, length=4)
     */
    protected $_graduation;

    /**
     * @ORM\OneToMany(targetEntity="Subscription", mappedBy="subscriber", cascade={"remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $_subscriptions;

    /**
     * @ORM\OneToOne(targetEntity="Address", cascade={"remove"})
     */
    protected $_facturationAddress;

    /**
     * @ORM\OneToOne(targetEntity="Address", cascade={"remove"})
     */
    protected $_deliveryAddress;

    /**
     * @ORM\Column(name="wantsBill", type="boolean")
     */
    protected $_wantsBill;

    /**
     * @ORM\Column(name="paperversion", type="boolean", nullable=false)
     */
    //protected $_paperVersion;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="_subscriber")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    protected $_user;

    /**
     * @ORM\Column(name="vatNumber", type="string", nullable=true, length=150)
     */
    protected $_vatNumber;

    public function __construct(){
        //$this->setPaperVersion(true);
    }

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
     * Add one subscription
     * @param Subscription
     * @return this
     */
    public function addSubscription($subscription)
    {
        if(!$this->_subscriptions){
            $this->setSubscriptions($subscription);
            return $this;
        }

        if(!$this->_subscriptions->contains($subscription)){
            $this->_subscriptions->add($subscription);
        }
        return $this;
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

    /**
     * @return boolean
     */
    public function getActiveSubscription()
    {
        foreach ($this->_subscriptions as $subscription) {
           if($subscription->isActive()){return $subscription;}
        }
        return null;
    }

        /**
    *Set this subscriber's facturation address
    *@param Address address
    */
    public function setFacturationAddress($address){
        $this->_facturationAddress = $address;
    }

    /**
    * Get this subscriber's facturation address
    *@return Address address
    */
    public function getFacturationAddress(){
        return $this->_facturationAddress;
    }

    /**
    *Set this subscriber's delivery address
    *@param Address address
    */
    public function setDeliveryAddress($address){
        $this->_deliveryAddress = $address;
    }

    /**
    * Get this subscriber's delivery address
    *@return Address address
    */
    public function getDeliveryAddress(){
        return $this->_deliveryAddress;
    }
    
    /*
    /**
    *Set if this subscriber's wants paper version or not
    *@param Address address
  
    public function setPaperVersion($boolean){
        $this->_paperVersion = $boolean;
    }

    /**
    * Get if subscriber wants paper version or not
    *@return boolean paperVersion
    
    public function getPaperVersion(){
        return $this->_paperVersion;
    }
    */

	/**
	* Set user
	* @param $user
	* @return this
	*/
	public function setUser($user){
		$this->_user= $user;

		return $this;
	}

	/**
     * @return String username
     */
	public function getUser(){
		return $this->_user;
	}

    /**
     * get wantsBill
     *
     * @return boolean
     */
    public function getWantsBill()
    {
        return $this->_wantsBill;
    }

    /**
     * set wantsBill
     *
     * @param boolean
     * @return this
     */
    public function setWantsBill($wants)
    {
        $this->_wantsBill = $wants;
        return $this;
    }

    /**
    *Set this subscriber's vat number
    *@param string vatNumber
    */
    public function setVatNumber($vatNumber){
        $this->_vatNumber = $vatNumber;
    }

    /**
    * Get this subscriber's vat number
    *@return string vatNumber
    */
    public function getVatNumber(){
        return $this->_vatNumber;
    }


}
