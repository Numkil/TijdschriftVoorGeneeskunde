<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Class Notice
 * @ORM\Entity
 * @ORM\Table(name="notice")
 */
class Notice{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	/**
	* @ORM\Column(name="title", type="string", nullable=false, length=150)
	*/
	private $title;
	/**
	* @ORM\Column(name="message", type="text", nullable=false, length=150)
	*/
	private $message;
	/**
	* @ORM\Column(name="creationDate", type="datetime", nullable=false, length=150)
	*/
	private $creationDate;

	public function __construct(){
		$this->creationDate = new \DateTime();
	}

	public function setId($id){
		$this->id = $id;

		return $this;
	}

	public function getId(){
		return $this->id;
	}

	public function setTitle($title){
		$this->title = $title;

		return $this;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setMessage($message){
		$this->message = $message;

		return $this;
	}

	public function getMessage(){
		return $this->message;
	}
	
	public function setCreationDate($creationDate){
		$this->creationDate = $creationDate;

		return $this;
	}

	public function getCreationDate(){
		return $this->creationDate;
	}
}