<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\Table(name="regular_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $_id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150)
     */
    protected $_name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=150)
     */
    protected $_firstname;

    /**
     * @var integer
     *
     * @ORM\Column(name="telephone", type="integer", length=150)
     */
    protected $_telephone;

    /**
     * @var Role[]
     *
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     */
    protected $_roles;

    /**
     * @var Subscriber
     *
     * ORM\OneToOne(targetEntity="Subscriber", inversedBy="user")
     * @ORM\JoinColumn(name="subscriber", nullable=true, referencedColumnName="id")
     */
    protected $_subscriber;

    /**
     * @var Bookstore
     *
     * ORM\ManyToOne(targetEntity="Bookstore", inversedBy="users")
     * @ORM\JoinColumn(name="bookstore", nullable=true, referencedColumnName="id")
     */
    protected $_bookstore;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        #hack hack hack
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return this
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstname;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return this
     */
    public function setFirstName($name)
    {
        $this->_firstname = $name;

        return $this;
    }

    /**
     * Get Telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }

    /**
     * Set name
     *
     * @param integer $telephone
     * @return this
     */
    public function setTelephone($telephone)
    {
        $this->_telephone = $telephone;

        return $this;
    }

    /**
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return $this->_roles->toArray();
    }

    /**
     * @param Role[] role
     * @return this
     */
    public function setRoles(array $roles)
    {
        $this->_roles = new ArrayCollection($roles);

        return $this;
    }

    /**
     * @return Subscriber
     */
    public function getSubscriber()
    {
        return $this->_subscriber;
    }

    /**
     * @param Subscriber
     * @return this
     */
    public function setSubscriber($subscriber)
    {
        $this->_subscriber = $subscriber;

        return $this;
    }

    /**
     * @return Bookstore
     */
    public function getBookstore()
    {
        return $this->_bookstore;
    }

    /**
     * @param Bookstore
     * @return this
     */
    public function setBookstore($bookstore)
    {
        $this->_bookstore = $bookstore;

        return $this;
    }
}
