<?php

namespace AppBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class LoginListener
 * Updates a user roles depending on the date and their subscription
 */
class LoginListener extends ContainerAware{
    /** @var ContainerInterface */
    protected $container;
    protected $security;
    protected $session;

    public function __construct(SecurityContextInterface $security, Session $session)
    {
        $this->security = $security;
        $this->session = $session;
    }

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        if ($this->security->isGranted('ROLE_PAIDUSER') &&
            !$this->security->isGranted('ROLE_PRINTER'))
        {
            $em = $this->container->get('doctrine')->getEntityManager();
            $user = $this->security->getToken()->getUser();

            if (!$user->getSubscriber()->hasActiveSubscription()) {
                $user->removeRole('ROLE_PAIDUSER');
                $em->flush();
            }

        }
    }

}
