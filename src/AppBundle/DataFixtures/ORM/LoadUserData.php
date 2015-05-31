<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

/**
 * Class LoadRoleData
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface
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

        $fosusermanager = $this->container->get('fos_user.user_manager');

        //FOSUserBundle stuffs
        $user = $fosusermanager->createUser();
        $user->setUserName('testuser');
        $user->setEmail('testuser@test.test');
        $user->setPlainPassword('p@ssword');
        $user->setEnabled(true);

        //TvG specific data
        $user->setName('test');
        $user->setFirstName('dev');
        $number = '0497 333 676';
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $benumber = $phoneUtil->parse($number, 'BE');
        $user->setTelephone($benumber);
        //Role of the testuser ==> every access
        $user->setRoles(array('ROLE_SUPER_ADMIN'));

        $manager->persist($user);

        //FOSUserBundle stuffs
        $user = $fosusermanager->createUser();
        $user->setUserName('testuserbookstore');
        $user->setEmail('testuser@bookstore.test');
        $user->setPlainPassword('p@ssword');
        $user->setEnabled(true);

        //TvG specific data
        $user->setName('testbookstore');
        $user->setFirstName('devbookstore');
        $number = '0497 444 676';
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $benumber = $phoneUtil->parse($number, 'BE');
        $user->setTelephone($benumber);
        //Role of the testuser ==> every access
        $user->setRoles(array('ROLE_USER'));

        $manager->persist($user);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
