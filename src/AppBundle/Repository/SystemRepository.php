<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\System;

/**
 * class SystemRepository
 *
 */
class SystemRepository extends EntityRepository
{
    public function incrementInvoiceNumber(){
        $system = $this->findOneBy(array('id' => 1));
        $system->setInvoiceNumber($system->getInvoiceNumber() + 1);
        $this->getEntityManager()->flush();
    }

    public function getInvoiceNumber(){
        $system = $this->findOneBy(array('id' => 1));
	    return $system->getInvoiceNumber();
    }
}
