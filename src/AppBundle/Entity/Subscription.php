<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 *Class Subscription
 */
class Subscription{

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

    public function __construct(\DateTime $startDate, \DateTime $endDate){
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
        $this->isPaid(false);
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
        if(new \DateTime() >= $this->startDate && new \DateTime() <= $this->endDate){
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
}
