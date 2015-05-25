<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Role;

/**
 * Class LoadRoleData
 */
class LoadRoleData implements FixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
       $role = new Role();
       $role->setName('User');
       $role->setRole('ROLE_USER');
       $manager->persist($role);

       $role = new Role();
       $role->setName('Payed User');
       $role->setRole('ROLE_PAIDUSER');
       $manager->persist($role);

       $role = new Role();
       $role->setName('Printer');
       $role->setRole('ROLE_PRINTER');
       $manager->persist($role);

       $role = new Role();
       $role->setName('Admin');
       $role->setRole('ROLE_ADMIN');
       $manager->persist($role);

       $role = new Role();
       $role->setName('Super Admin');
       $role->setRole('ROLE_SUPER_ADMIN');
       $manager->persist($role);

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
