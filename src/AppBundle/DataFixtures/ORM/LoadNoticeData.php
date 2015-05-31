<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Notice;

/**
 * Class LoadRoleData
 */
class LoadNoticeData implements FixtureInterface, ContainerAwareInterface
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

        $notice = new Notice();
        $notice->setTitle('Fixture notice 1');
        $notice->setMessage('Message body fixture notice 1');
        $manager->persist($notice);

        $notice = new Notice();
        $notice->setTitle('Fixture notice 2');
        $notice->setMessage('Message body fixture notice 2');
        $manager->persist($notice);

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
