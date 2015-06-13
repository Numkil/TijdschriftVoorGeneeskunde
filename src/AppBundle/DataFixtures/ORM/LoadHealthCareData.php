<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\HealthCare;
use AppBundle\Entity\Address;

/**
 * Class LoadHealthCareData
 */
class LoadHealthCareData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $healthcare = new HealthCare();
        $healthcare->setName('Begrensde kwakzalvers');
        $healthcare->setEmail('begrensde@kwak.zalvers');

        $number = '0497 623 321';
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $benumber = $phoneUtil->parse($number, 'BE');
        $healthcare->setTelephone($benumber);

        $address = new Address();
        $address->setStreet('straat 6');
        $address->setMunicipality('gemeente 6');
        $address->setPostalCode(4420);
        $address->setCountry('Belgium');
        $healthcare->setAddress($address);

        $manager->persist($address);
        $manager->persist($healthcare);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
