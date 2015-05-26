<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;

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
        $user->setTelephone(0497333676);

        //Role of the testuser ==> every access
        $user->setRoles(array('ROLE_SUPER_ADMIN'));

        $manager->persist($user);
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
