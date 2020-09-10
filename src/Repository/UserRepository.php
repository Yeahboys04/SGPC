<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    // ...

    public function loadUserByUsername($login)
    {
        return $this->createQuery(
                'SELECT u
                FROM App\Entity\User u
                WHERE u.login = :query'
            )
            ->setParameter('query', $login)
            ->getQuery()
            ->getOneOrNullResult();
    }
}