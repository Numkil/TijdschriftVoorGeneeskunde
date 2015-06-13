<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Invoice
 * @ORM\Entity
 * @ORM\Table(name="invoice")
 */
class Invoice
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\Column(name="date", type="datetime")
     * @var \DateTime
     */
    private $_date;

     /**
     * @ORM\Column(name="name", type="string", length=150)
     */
    protected $_name;

     /**
     * @ORM\Column(name="street", type="string", length=150)
     */
    protected $_street;

     /**
     * @ORM\Column(name="municipality", type="string", length=150)
     */
    protected $_municipality;

    /**
     * @ORM\Column(name="postalCode", type="string", length=150)
     */
    protected $_postalCode;

     /**
     * @ORM\Column(name="vatNumber", type="string", length=150)
     */
    protected $_vatNumber;

     /**
     * @ORM\Column(name="orderNumber", type="string", nullable=true, length=150)
     */
    protected $_orderNumber;

     /**
     * @ORM\Column(name="invoiceNumber", type="string", length=150)
     */
    protected $_invoiceNumber;

    /**
     * @ORM\Column(name="price", type="string", length=150)
     */
    protected $_price;

     /**
     * @ORM\Column(name="discount", type="float", length=150)
     */
    protected $_discount;

    /**
     * @ORM\Column(name="ogm", type="string", length=150)
     */
    protected $_ogm;

    /**
     * @ORM\ManyToOne(targetEntity="Subscription", inversedBy="_invoices")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $_subscription;

    /**
     * @ORM\ManyToOne(targetEntity="Bookstore", inversedBy="_invoices")
     * @ORM\JoinColumn(name="bookstore", onDelete="CASCADE")
     */
    protected $_bookstore;

    /**
     * @ORM\ManyToOne(targetEntity="Healthcare", inversedBy="_invoices")
     * @ORM\JoinColumn(name="healthcare", onDelete="CASCADE")
     */
    protected $_healthcare;

    /**
     * @ORM\Column(name="isPaid", type="boolean")
     */
    protected $_isPaid;

    /**
    *Set this invoice's id
    *@param integer id
    *@return this
    */
    private function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
    *Set this invoice's id
    *@return integer id
    */
    public function getId(){
        return $this->id;
    }

    /**
    *Set this invoice's date
    *@param Date date
    *@return this
    */
    public function setDate($date){
        $this->_date = $date;
        return $this;
    }

    /**
    *Set this invoice's date
    *@return Date date
    */
    public function getDate(){
        return $this->_date;
    }

    /**
    *Set this invoice's street
    *@param string street
    *@return this
    */
    public function setStreet($street){
        $this->_street = $street;
        return $this;
    }

    /**
    *Set this invoice's street
    *@return String street
    */
    public function getStreet(){
        return $this->_street;
    }

    /**
    *Set this invoice's name
    *@param string name
    *@return this
    */
    public function setName($name){
        $this->_name = $name;
        return $this;
    }

    /**
    *Set this invoice's name
    *@return String name
    */
    public function getName(){
        return $this->_name;
    }

    /**
    *Set this invoice's municipality
    *@param string municipality
    *@return this
    */
    public function setMunicipality($municipality){
        $this->_municipality = $municipality;
        return $this;
    }

    /**
    *Set this invoice's municipality
    *@return String municipality
    */
    public function getMunicipality(){
        return $this->_municipality;
    }

    /**
    *Set this invoice's postalCode
    *@param string postalCode
    *@return this
    */
    public function setPostalCode($postalCode){
        $this->_postalCode = $postalCode;
        return $this;
    }

    /**
    *Set this invoice's postalCode
    *@return String postalCode
    */
    public function getPostalCode(){
        return $this->_postalCode;
    }

    /**
    *Set this invoice's vatNumber
    *@param string vatNumber
    *@return this
    */
    public function setVatNumber($vatNumber){
        $this->_vatNumber = $vatNumber;
        return $this;
    }

    /**
    *Set this invoice's vatNumber
    *@return String vatNumber
    */
    public function getVatNumber(){
        return $this->_vatNumber;
    }

    /**
    *Set this invoice's orderNumber
    *@param string orderNumber
    *@return this
    */
    public function setOrderNumber($orderNumber){
        $this->_orderNumber = $orderNumber;
        return $this;
    }

    /**
    *Set this invoice's orderNumber
    *@return String orderNumber
    */
    public function getOrderNumber(){
        return $this->_orderNumber;
    }

    /**
    *Set this invoice's invoiceNumber
    *@param string invoiceNumber
    *@return this
    */
    public function setInvoiceNumber($invoiceNumber){
        $this->_invoiceNumber = $invoiceNumber;
        return $this;
    }

    /**
    *Set this invoice's invoiceNumber
    *@return String invoiceNumber
    */
    public function getInvoiceNumber(){
        return $this->_invoiceNumber;
    }

    /**
    *Set this invoice's price
    *@param string price
    *@return this
    */
    public function setPrice($price){
        $this->_price = $price;
        return $this;
    }

    /**
    *Set this invoice's price
    *@return String price
    */
    public function getPrice(){
        return $this->_price;
    }

    /**
    *Set this invoice's discount
    *@param string discount
    *@return this
    */
    public function setDiscount($discount){
        $this->_discount = $discount;
        return $this;
    }

    /**
    *Set this invoice's discount
    *@return String discount
    */
    public function getDiscount(){
        return $this->_discount;
    }

    /**
    *Set this invoice's ogm
    *@param string ogm
    *@return this
    */
    public function setOgm($ogm){
        $this->_ogm = $ogm;
        return $this;
    }

    /**
    *Set this invoice's ogm
    *@return String ogm
    */
    public function getOgm(){
        return $this->_ogm;
    }

    /**
     * @param Subscription $subscription
     * @return this
     */
    public function setSubscription($subscription){
        $this->_subscription = $subscription;
        return $this;
    }

    /**
     * @return Subscription subscription
     */
    public function getSubscription(){
        return $this->_subscription;
    }

    /**
     * @param Bookstore $bookstore
     * @return this
     */
    public function setBookstore($bookstore){
        $this->_bookstore = $bookstore;
        return $this;
    }

    /**
     * @return Bookstore bookstore
     */
    public function getBookstore(){
        return $this->_bookstore;
    }

    /**
     * @param Healthcare $healthcare
     * @return this
     */
    public function setHealthcare($healthcare){
        $this->_healthcare = $healthcare;
        return $this;
    }

    /**
     * @return Healthcare healthcare
     */
    public function getHealthcare(){
        return $this->_healthcare;
    }

}