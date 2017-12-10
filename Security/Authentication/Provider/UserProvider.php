<?php

namespace App\Oni\UserManagerBundle\Security\Authentication\Provider;


use App\Oni\UserManagerBundle\Service\UserServiceInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use App\Oni\UserManagerBundle\Entity\User;


class UserProvider implements UserProviderInterface
{

    /**
     * @var \App\Oni\UserManagerBundle\Service\UserServiceInterface
     */
    protected $userService;


    public function __construct(UserServiceInterface $userService){

        $this->userService = $userService;

    }

    public function loadUserByUsername($username)
    {

        if ($username) {

            $user = $this->userService->findByUsername($username);

        }

        if (!$user instanceof User || empty($user)) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $username)
            );
        } else {

            return $user;

        }

    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof UserInterface) {
            throw new UnsupportedUserException(sprintf('Expected an instance of FOS\UserBundle\Model\UserInterface, but got "%s".', get_class($user)));
        }

        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Expected an instance of %s, but got "%s".', $this->userService->getEntityClass(), get_class($user)));
        }

        if (null === $reloadedUser = $this->loadUserByUsername($user->getUsername())) {
            throw new UsernameNotFoundException(sprintf('User with ID "%s" could not be reloaded.', $user->getId()));
        }

        return $reloadedUser;
    }


    public function supportsClass($class)
    {
        return $class === $this->userService->getEntityClass();
    }
}