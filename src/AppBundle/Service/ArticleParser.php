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

    /**
     * @return array[] article
     */
	public function fetchAllArticles(){

        $curl = curl_init('http://'.$this->getHostname().'?jaar='.date('Y').'&order1=jaar');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $response = json_decode($curl_response, true);
        curl_close($curl);
        return $response;
	}

    /**
     * TODO:  Don't forget to escape the query in controller
     * @param String query
     * @return array[] article
     */
	public function fetchAllArticlesForQuery($query){

        $url = $this->getHostname();
        $hasquery = false;
        foreach ($query as $key => $value) {
            if($value){
                if (strpos($url, '?') === false) {
                    $url = $url.'?';
                }else{
                    $url = $url.'&';
                }
                if($key == "boekbespreking")
                {
                    $url = $url.'boek=y';
                }else{
                    $url = $url.$key.'='.$value;
                }
                $hasquery = true;
            }
        }
        if (!$hasquery) {
            return $this->fetchAllArticles();
        }
        $curl = curl_init('http://'.$url.'&order1=jaar');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $response = json_decode($curl_response, true);
        curl_close($curl);
        return $response;
	}
}
