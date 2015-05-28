<?php

namespace AppBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
*Class Article	
*/
class Article{
	
	private $id;
	private $type;
	private $title;
	private $subtitle;
	private $summery;
	private $authors;
	private $tags;
	private $categories;
	private $collumns;
	private $year;
	private $volume;
	private $number;
	private $startPage;
	private $endPage;
	private $classification;

	 /**
     * Set id for article
     * @param String $id
     * @return this
     */
	public function setId($id){
		$this->id = $id;

		return $this;
	}

	public function getId(){
		return $this->id;
	}

	 /**
     * Set type for article
     * @param String $type
     * @return this
     */
	public function setType($type){
		$this->type = $type;

		return $this;
	}

	public function getType(){
		return $this->type;
	}

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

	public function setSubtitle($subtitle){
		$this->subtitle = $subtitle;

		return $this;
	}

	public function getSubtitle(){
		return $this->subtitle;	
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
     * Set array of authors
     * @param String[] $authors
     * @return this
     */
	public function setAuthors($authors){
		if(!is_array($authors)){
			$authors = array($authors);
		}
		$this->authors = new ArrayCollection($authors);

		return $this;
	}

	 /**
     * Add one authors to authors
     * @param String $authors
     * @return this
     */
	public function addAuthor($author){
		if(!$this->authors->contains($author)){
			$this->authors->add($author);
		}

		return $this;
	}

	public function getAllAuthors(){
		return $this->authors;
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
     * Set array of categories
     * @param String[] $categories
     * @return this
     */
	public function setCategories($categories){
		if(!is_array($categories)){
			$categories = array($categories);
		}
		$this->categories = new ArrayCollection($categories);

		return $this;
	}

	 /**
     * Add one categorie to categories
     * @param String $categorie
     * @return this
     */
	public function addCategories($categorie){
		if(!$this->categories->contains($categorie){
			$this->categories->add($categorie);
		}

		return $this;
	}

	public function getCategories(){
		return $this->categories;
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

	 /**
     * @param String $startPage
     * @return this
     */
	public function setStartPage($startPage){
		$this->startPage = $startPage;

		return $this;
	}

	public function getStartPage(){
		return $this->startPage;
	}

	 /**
     * @param String $endPage
     * @return this
     */
	public function setEndPage($endPage){
		$this->endPage = $endPage;

		return $this;
	}

	public function getEndPage(){
		return $this->endPage;
	}

	 /**
     * @param String $classification
     * @return this
     */
	public function setClassification($classification){
		$this->classification = $classification;

		return $this;
	}

	public function getClassification(){
		return $this->classification;
	}

}