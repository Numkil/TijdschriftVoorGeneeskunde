<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class healthcare
 * @ORM\Entity
 * @ORM\Table(name="healthcare")
 */
class HealthCare extends Organization
{
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="_healthcare")
     */
    protected $_subscribers;
}
