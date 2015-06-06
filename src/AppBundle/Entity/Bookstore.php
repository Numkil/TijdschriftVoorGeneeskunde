<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Bookstore
 * @ORM\Entity
 * @ORM\Table(name="bookstore")
 */
class Bookstore extends Organization
{
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="_bookstore")
     */
    protected $_subscribers;
}
