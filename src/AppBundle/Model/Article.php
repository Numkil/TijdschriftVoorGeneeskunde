<?php

namespace AppBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
*Class Article	
*/
class Article{
	
	private $title;
	private $summery;
	private $autors;
	private $tags;
	private $subjects;
	private $collumns;
	private $year;
	private $volume;
	private $number;


	 /**
     * Set name for article
     * @param String $title
     * @return this
     */
	public function setTitle($title){
		$this->title = $title;

		return $this;
	}


	public function getTitle(){
		return $this->title;
	}

	 /**
     * Set summery for article
     * @param String $summery
     * @return this
     */
	public function setSummery($summery){
		$this->summery = $summery;

		return $this;
	}

	public function getSummery(){
		return $this->summery;
	}

	 /**
     * Set array of autors
     * @param String[] $autors
     * @return this
     */
	public function setAutors($autors){
		if(!is_array($autors)){
			$autors = array($autors);
		}
		$this->autors = new ArrayCollection($autors);

		return $this;
	}

	 /**
     * Add one autor to autors
     * @param String $autor
     * @return this
     */
	public function addAutor($autor){
		if(!$this->autors->contains($autor)){
			$this->autors->add($autor);
		}

		return $this;
	}

	public function getAllAutors(){
		return $this->autors;
	}

	 /**
     * Set tags
     * @param String[] tags
     * @return this
     */
	public function setTags($tags){
		if(!is_array($tags)){
			$tags = array($tags);
		}
		$this->tags = new ArrayCollection($tags);

		return $this;
	}

	 /**
     * Add one tag to tags
     * @param String $tag
     * @return this
     */
	public function addTag($tag){
		if(!$this->tags->contains($tag)){
			$this->tags->add($tag);
		}

		return $this;
	}

	public function getAllTags(){
		return $this->tags;
	}

	 /**
     * Set array of subjects
     * @param String[] $subjects
     * @return this
     */
	public function setSubjects($subjects){
		if(!is_array($subjects)){
			$subjects = array($subjects);
		}
		$this->subjects = new ArrayCollection($subjects);

		return $this;
	}

	 /**
     * Add one subject to subjects
     * @param String $subject
     * @return this
     */
	public function addSubject($subject){
		if(!$this->subjects->contains($subjects){
			$this->subjects->add($subject);
		}

		return $this;
	}

	public function getSubjects(){
		return $this->subjects;
	}

	 /**
     * Set array of collumns
     * @param String[] $collumns
     * @return this
     */
	public function setCollumns($collumns){
		if(!is_array($collumns)){
			$collumns = array($collumns);
		}
		$this->collumns = $collumns;

		return $this;
	}

	 /**
     * Add one collumn to collumns
     * @param String $collumns
     * @return this
     */
	public function addCollumn($collumn){
		if(!$this->collumns->contains($collumn)){
			$this->collumns->add($collumn);
		}

		return $this;
	}

	public function getCollumns(){
		return $this->collumns;
	}

	 /**
     * @param String $year
     * @return this
     */
	public function setYear($year){
		$this->year = $year;

		return $this;
	}

	public function getYear(){
		return $this->year;
	}

	 /**
     * @param String volume
     * @return this
     */
	public function setVolume($volume){
		$this->volume = $volume;

		return $this;
	}

	public function getVolume(){
		return $this->volume;
	}

	 /**
     * @param String $number
     * @return this
     */
	public function setNumber($number){
		$this->number = $number;

		return $this;
	}

	public function getNumber(){
		return $this->number;
	}

}