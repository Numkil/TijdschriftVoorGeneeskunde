<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class SideMenuBuilder
 */
class SideMenuBuilder extends ContainerAware
{
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $security = $this->container->get('security.context');
        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav navbar-nav side-nav',
            ),
        ));

        $menu->addChild($this->container->get('translator')->trans('Home'), array('route' => 'glance'));
        if($security->isGranted('ROLE_PAIDUSER'))
        {
            $menu->addChild($this->container->get('translator')->trans('Articles'), array('route' => 'articleOverview'));
        }
        $menu->addChild($this->container->get('translator')->trans('Notices'), array('route' => 'noticeOverview'));
        $menu->addChild($this->container->get('translator')->trans('Agenda'), array('route' => 'agenda'));
        $menu->addChild($this->container->get('translator')->trans('Editors'), array('route' => 'editors'));
        $menu->addChild($this->container->get('translator')->trans('Guidelines for authors'), array('route' => 'guidelines'));
        $menu->addChild($this->container->get('translator')->trans('Interesting links'), array('route' => 'links'));
        $menu->addChild($this->container->get('translator')->trans('Vacancies & messages'), array('route' => 'vacancies'));
        $menu->addChild($this->container->get('translator')->trans('Contact'), array('route' => 'contact'));
        return $menu;
    }
}
