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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150)
     */
    protected $_name;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="phone_number")
     * @AssertPhoneNumber(defaultRegion="BE")
     */
    protected $_telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150)
     */
    protected $_email;

    /**
    *@var Address
    *
    * @ORM\OneToOne(targetEntity="Address", mappedBy="address")
    */
    protected $_address;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="subscriber")
     */
    protected $_subscribers;


    /**
    *Set this bookstore's name
    *@param String name
    */
    public function setName($name){
        $this->_name = $name;
    }

    /**
    * Get this bookstore's name
    *@return String name
    */
    public function getName(){
        return $this->_name;
    }

    /**
    *Set this bookstore's telephone
    *@param String telephone
    */
    public function setTelephone(\libphonenumber\PhoneNumber $telephone)
    {
        $this->_telephone = $telephone;
    }

    /**
    * Get this bookstore's telephone
    *@return String telephone
    */
    public function getTelephone(){
        return $this->_telephone;
    }

    /**
    *Set this bookstore's email address
    *@param String email
    */
    public function setEmail($email){
        $this->_email = $email;
    }

    /**
    * Get this bookstore's email address
    *@return String email
    */
    public function getEmail(){
        return $this->_email;
    }

    /**
    *Set this bookstore's address
    *@param Address address
    */
    public function setAddress($address){
        $this->_address = $address;
    }

    /**
    * Get this bookstore's address
    *@return Address address
    */
    public function getAddress(){
        return $this->_address;
    }

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
