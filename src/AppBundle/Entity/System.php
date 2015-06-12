<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class System
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SystemRepository")
 * @ORM\Table(name="system")
 */
class System
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="invoiceNumber", type="integer")
     */
    protected $_invoiceNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150)
     */
    protected $_name;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=150)
     */
    protected $_street;

    /**
     * @var string
     *
     * @ORM\Column(name="municipality", type="string", length=150)
     */
    protected $_municipality;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=150)
     */
    protected $_postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="iban", type="string", length=150)
     */
    protected $_iban;

    /**
     * @var string
     *
     * @ORM\Column(name="bic", type="string", length=150)
     */
    protected $_bic;

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->$id;
    }

    public function setInvoiceNumber($invoiceNumber){
        $this->_invoiceNumber = $invoiceNumber;
    }

    public function getInvoiceNumber(){
        return $this->_invoiceNumber;
    }

    public function setName($name){
        $this->_name = $name;
    }

    public function getName(){
        return $this->_name;
    }

    public function setStreet($street){
        $this->_street = $street;
    }

    public function getStreet(){
        return $this->_street;
    }

    public function setMunicipality($municipality){
        $this->_municipality = $municipality;
    }

    public function getMunicipality(){
        return $this->_municipality;
    }

    public function setPostalCode($postalCode){
        $this->_postalCode = $postalCode;
    }

    public function getPostalCode(){
        return $this->_postalCode;
    }

    public function setIban($iban){
        $this->_iban = $iban;
    }

    public function getIban(){
        return $this->_iban;
    }

    public function setBic($bic){
        $this->_bic = $bic;
    }

    public function getBic(){
        return $this->_bic;
    }

}
