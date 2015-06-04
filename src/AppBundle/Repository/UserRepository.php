<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * UserRepository
 *
 */
class UserRepository extends EntityRepository
{
    /**
     * Searches all the user objects with a paid subscription
     *
     * @return User[]
     */
    public function findActiveSubscribers()
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u, s')
            ->innerJoin('u._subscriber', 's')
            ->innerJoin('s._deliveryAddress', 'd')
            ->innerJoin('s._subscriptions', 'sp')
            ->where('sp.isPaid = 1')
            ->andWhere('sp.endDate >= :today')
            ->setParameter('today', new \DateTime());

        $users = $qb->getQuery()->getResult();

        return $users;
    }

    /**
     * Searches all the user objects with a paid subscription and counts the result
     *
     * @return int
     */
    public function findCountActiveSubscribers()
    {
        $qb = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->innerJoin('u._subscriber', 's')
            ->innerJoin('s._deliveryAddress', 'd')
            ->innerJoin('s._subscriptions', 'sp')
            ->where('sp.isPaid = 1')
            ->andWhere('sp.endDate >= :today')
            ->setParameter('today', new \DateTime());

        $users = $qb->getQuery()->getSingleScalarResult();

        return $users;
    }

}
