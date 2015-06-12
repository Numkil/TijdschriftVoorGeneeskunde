<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Class Promo
 * @ORM\Entity
 * @ORM\Table(name="promo")
 */
class Promo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150)
     */
    protected $_code;

    /**
     * @var string
     *
     * @ORM\Column(name="startDate", nullable=true, type="datetime")
     */
    protected $_startDate;

    /**
     * @var string
     * @ORM\Column(name="endDate", nullable=true, type="datetime")
     */
    protected $_endDate;

     /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param string $id
     * @return this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return this
     */
    public function setCode($code)
    {
        $this->_code = $code;
        return $this;
    }

    /**
     * Set startDate
     * @param string $startDate
     * @return this
     */    
    public function setStartDate($startDate){
        $this->_startDate = $startDate;
        return $this;
    }

     /**
     * Get startDate
     *
     * @return string
     */
    public function getStartDate(){
        return $this->_startDate;
    }

    /**
     * Set endDate
     * @param string $endDate
     * @return this
     */
    public function setEndDate($endDate){
        $this->_endDate = $endDate;
        return $this;
    }

     /**
     * Get endDate
     *
     * @return string
     */
    public function getEndDate(){
        return $this->_endDate;
    }

}
