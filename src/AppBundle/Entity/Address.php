<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Address
 * @ORM\Entity
 * @ORM\Table(name="address")
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $_id;
    
	/**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=150)
     */
    protected $_street;

    /**
     * @var string
     *
     * @ORM\Column(name="postalcode", type="string", length=150)
     */
    protected $_postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="municipality", type="string", length=150)
     */
    protected $_municipality;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=150)
     */
    protected $_country;

    /**
    *Set this address' street
    *@param String street
    */
    public function setStreet($street){
        $this->_street = $street;
    }

    /**
    * Get this address' street
    *@return String street
    */
    public function getStreet(){
        return $this->_street;
    }

    /**
    *Set this address' postalcode
    *@param String postalcode
    */
    public function setPostalCode($postalCode){
        $this->_postalCode = $postalCode;
    }

    /**
    * Get this address' postalcode
    *@return String postalcode
    */
    public function getPostalCode(){
        return $this->_postalCode;
    }

    /**
    *Set this address' municipality
    *@param String municipality
    */
    public function setMunicipality($municipality){
        $this->_municipality = $municipality;
    }

    /**
    * Get this address' municipality
    *@return String municipality
    */
    public function getMunicipality(){
        return $this->_municipality;
    }

    /**
    *Set this address' country
    *@param String country
    */
    public function setCountry($country){
        $this->_country = $country;
    }

    /**
    * Get this address' country
    *@return String country
    */
    public function getCountry(){
        return $this->_country;
    }
}