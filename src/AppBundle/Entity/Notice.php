<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Class Notice
*/
class Notice{
	
	private $id;
	private $message;
	private $creationDate;

	public function setId($id){
		$this->id = $id;

		return $this;
	}

	public function getId(){
		return $this->id;
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