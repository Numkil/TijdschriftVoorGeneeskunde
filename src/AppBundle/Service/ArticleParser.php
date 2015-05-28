<?php

namespace AppBundle\Service;

use AppBundle\Model\Article;

/**
*Class ArticleParser
*/
class ArticleParser{
	private $hostname;
	private $encodingType;
	private $username;
	private $password;

    /**
     * @param mixed $hostname
     * @param mixed $encodingtype
     * @param mixed $username
     * @param mixed $password
     */
    public function __construct($hostname, $encodingtype, $username, $password)
    {
        $this->setHostname($hostname);
        $this->setEncodingType($encodingtype);
        $this->setUsername($username);
        $this->setPassword($password);
    }

	/**
	* Set hostname
	* @param String $hostname
	* @return this
	*/
	public function setHostname($hostname){
		$this->hostname = $hostname;

		return $this;
	}

	/**
     * @return String hostname
     */
	public function getHostname(){
		return $this->hostname;
	}

	/**
	* Set encodingType
	* @param String $encodingType
	* @return this
	*/
	public function setEncodingType($encodingType){
		$this->encodingType = $encodingType;

		return $this;
	}

	/**
     * @return String encodingType
     */
	public function getEncodingType(){
		return $this->encodingType;
	}

	/**
	* Set username
	* @param String $username
	* @return this
	*/
	public function setUsername($username){
		$this->username = $username;

		return $this;
	}

	/**
     * @return String username
     */
	public function getUsername(){
		return $this->username;
	}

	/**
	* Set password
	* @param String $password
	* @return this
	*/
	public function setPassword($password){
		$this->password = $password;
	}

	/**
     * @return String password
     */
	public function getPassword(){
		return $this->password;
	}


	public function fetchAllArticles(){

		$response = file_get_contents($this->hostname);
		$articleArray = json_decode($response);
//TODO: check if returns array
	}

	public function fetchArticle($url){
		/*
		this url contains the service url + the url containing 
		the parameters for fetching the correct article from peeters server
		*/
		$requestURL = $this->hostname . $url;
//TODO: exceptions		
		$response = file_get_contents($requestURL);
		$articleArray = json_decode($response);
		$article = parseArticle($articleArray);

		return $article;
	}

	/**
	* Parse article
	* @return Article article
	*/
	private function parseArticle(array $arrayArticle){
		/*
			this function will wrap the decoded json array into a Article object
		*/
		$article = new Article();

		$article->id = $arrayArticle['id'];
		$article->type = $arrayArticle['type'];
		$article->title = $arrayArticle['title'];
		$article->subtitle = $arrayArticle['subtitle'];
		$article->summery = $arrayArticle['summery'];
		$article->authors = $arrayArticle['authors'];
		$article->tags = $arrayArticle['tags'];
		$article->categories = $arrayArticle['categories'];
		$article->collumns = $arrayArticle['collumn'];
		$article->year = $arrayArticle['year'];
		$article->volume = $arrayArticle['volume'];
		$article->number = $arrayArticle['number'];
		$article->startPage = $arrayArticle['startPage'];
		$article->endPage = $arrayArticle['endPage'];
		$article->classification = $arrayArticle['classification'];

		return $article;
	}
}
