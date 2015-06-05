<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class SideMenuBuilder
 */
class SideMenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav navbar-nav side-nav',
            ),
        ));

        $menu->addChild($this->container->get('translator')->trans('Notices'), array('route' => 'noticeOverview'));
        $menu->addChild($this->container->get('translator')->trans('Editors'), array('route' => 'editors'));
        $menu->addChild($this->container->get('translator')->trans('At a glance'), array('route' => 'glance'));
        $menu->addChild($this->container->get('translator')->trans('Guidelines for authors'), array('route' => 'guidelines'));
        $menu->addChild($this->container->get('translator')->trans('Interesting links'), array('route' => 'links'));
        $menu->addChild($this->container->get('translator')->trans('Vacancies & messages'), array('route' => 'vacancies'));

        return $menu;
    }
}
