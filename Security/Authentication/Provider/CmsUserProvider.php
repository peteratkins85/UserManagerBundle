<?php

namespace Cms\UserManagerBundle\Security;


use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Cms\UserManagerBundle\Entity\Users;

class CmsUserProvider implements UserProviderInterface
{

    public function loadUserByUsername($username)
    {
        // make a call to your webservice here
        // pretend it returns an array on success, false if there is no user

        if ($userData) {
            $password = '...';

            // ...

            //return new Users();
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Cms\UserManagerBundle\Entity\Users';
    }
}