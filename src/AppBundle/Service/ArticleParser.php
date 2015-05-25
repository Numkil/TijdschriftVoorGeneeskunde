<?php

namespace AppBundle\Service;

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
		$this->username = $username;
	}

	/**
     * @return String password
     */
	public function getPassword(){
		return $this->password;
	}

	/**
	* Parse article
	* @return Article article
	*/
	public function parseArticle(){

	}
}
