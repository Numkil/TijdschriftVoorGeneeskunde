<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;


/**
 * Class Subscription
 * @ORM\Entity
 * @ORM\Table(name="subscription")
 */
class Subscription{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\Column(name="startDate", type="datetime")
     * @var \DateTime
     */
    private $startDate;

    /**
     *
     * @ORM\Column(name="endDate", type="datetime")
     * @var \DateTime
     */
    private $endDate;

    /**
     * @ORM\Column(name="isPaid", type="boolean")
     */
    protected $isPaid;

    /**
     * @ORM\ManyToOne(targetEntity="Subscriber", inversedBy="_subscriptions")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $subscriber;

    /**
     * @DoctrineAssert\Enum(entity="AppBundle\Entity\Types\PaymentType")
     * @ORM\Column(name="pricingtype", type="PaymentType", nullable=false)
     */
    protected $_pricingtype;

    /**
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="_subscription", cascade={"remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $_invoices;

    public function __construct(\DateTime $startDate, \DateTime $endDate){
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
        $this->setPaid(false);
    }

    /**
     * @param Subscriber
     * @return this
     */
    public function setSubscriber($subscriber){
        $this->subscriber = $subscriber;
        return $this;
    }

    /**
     * @return Subscriber subscriber
     */
    public function getSubscriber(){
        return $this->subscriber;
    }

    /**
     * @param Date $startDate
     * @return this
     */

    public function setStartDate(\DateTime $startDate){
        $this->startDate = $startDate;
        return $this;
    }

    public function getStartDate(){
        return $this->startDate;
    }

    /**
     * @param Date $endDate
     * @return this
     */
    public function setEndDate(\DateTime $endDate){
        $this->endDate = $endDate;
        return $this;
    }

    public function getEndDate(){
        return $this->endDate;
    }

    /**
     * @return boolean
     */
    public function isActive(){
        $today = new \DateTime();
        if($today >= $this->startDate && $today <= $this->endDate){
            return true;
        }

        return false;
    }

    /**
     * @param boolean $boolean
     * @return this
     */
    public function setPaid($boolean){
        $this->isPaid = $boolean;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPaid(){
        return $this->isPaid;
    }

    public function setId($id){
        $this->id = $id;

        return $this;
    }

    public function getId(){
        return $this->id;
    }

    /**
     * @Assert\Callback
     */
    public function isEndGreater(ExecutionContextInterface $context)
    {
        if ($this->startDate->getTimestamp() > $this->endDate->getTimestamp()) {
            $context->buildViolation('The end date must be larger than the start date')
                ->atPath('endDate')
                ->addViolation();
        }
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
