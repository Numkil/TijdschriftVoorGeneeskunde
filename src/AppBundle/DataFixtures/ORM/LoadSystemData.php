<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\System;

/**
 * Class LoadRoleData
 */
class LoadSystemData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /** @var ContainerInterface */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $system = new System();
        $system->setInvoiceNumber(1);
        $system->setName("Tijdschrift voor geneesheren");
        $system->setStreet("Minderbroedersstraat 12");
        $system->setMunicipality("Leuven");
        $system->setPostalCode("3000");
        $system->setIban("BE08000048578913");
        $system->setBic("BPOTBEB1");

        $manager->persist($system);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
