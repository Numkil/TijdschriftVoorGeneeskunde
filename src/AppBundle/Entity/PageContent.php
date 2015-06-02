<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class PageContent
 * @ORM\Entity
 * @ORM\Table(name="pagecontent")
 */
class PageContent
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", name="url", length=100)
     */
    private $_url;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string")
     */
    protected $_content;


    /**
     * @param mixed $url
     */
    public function __construct($url, $content)
    {
        $this->_url = $url;
        $this->_content = $content;
    }

    /**
     * get Content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * set Content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    /**
     * get Url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * set Url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

}
