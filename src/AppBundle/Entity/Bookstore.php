<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Bookstore
 * @ORM\Entity
 * @ORM\Table(name="bookstore")
 */
class Bookstore extends Organization
{
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="_bookstore")
     */
    protected $_subscribers;

     /**
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="_bookstore", cascade={"remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $_invoices;

    /**
     * @param Invoice[] $invoices
     * @return this
     */
    public function setInvoices($invoices)
    {
        if(!is_array($invoices)){
           $invoices = array($invoices);
        }
        $this->_invoices = new ArrayCollection($invoices);

        return $this;
    }

    /**
     * @return Invoice[] invoices
     */
    public function getInvoices()
    {
        return $this->_invoices;
    }

    /**
     * Add one invoice
     * @param Invoice
     * @return this
     */
    public function addInvoice($invoice)
    {
        if(!$this->_invoices){
            $this->setInvoices($invoice);
            return $this;
        }

        if(!$this->_invoices->contains($invoice)){
            $this->_invoices->add($invoice);
        }
        return $this;
    }
}
