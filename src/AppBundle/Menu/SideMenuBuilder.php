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

        $menu->addChild('Notices', array('route' => 'noticeOverview'));

        return $menu;
    }
}
