<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Bookstore;
use AppBundle\Entity\Address;

/**
 * Class LoadBookstoreDate
 */
class LoadBookstoreData implements FixtureInterface, ContainerAwareInterface
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
        $bookstore = new Bookstore();
        $bookstore->setName('Standaard Boekenzwendel');
        $bookstore->setEmail('Standaard@boek.zwendel');

        $number = '0497 623 543';
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $benumber = $phoneUtil->parse($number, 'BE');
        $bookstore->setTelephone($benumber);

        $address = new Address();
        $address->setStreet('straat 1');
        $address->setMunicipality('gemeente 1');
        $address->setPostalCode(4498);
        $address->setCountry('Belgium');
        $bookstore->setAddress($address);

        $user = $manager->getRepository('AppBundle:User')->findOneBy(array('username' => 'testuserbookstore'));
        $user->setBookstore($bookstore);
        $bookstore->addSubscriber($user);

        $manager->persist($address);
        $manager->persist($bookstore);


        $bookstore = new Bookstore();
        $bookstore->setName('de goeie');
        $bookstore->setEmail('de@goei.zwendel');

        $number = '0497 623 888';
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $benumber = $phoneUtil->parse($number, 'BE');
        $bookstore->setTelephone($benumber);

        $address = new Address();
        $address->setStreet('straat 2');
        $address->setMunicipality('gemeente 2');
        $address->setPostalCode(5598);
        $address->setCountry('Belgium');
        $bookstore->setAddress($address);

        $manager->persist($address);
        $manager->persist($bookstore);


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
