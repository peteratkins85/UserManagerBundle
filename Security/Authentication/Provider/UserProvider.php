<?php

namespace Cms\UserManagerBundle\Security\Authentication\Provider;


use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Cms\UserManagerBundle\Entity\User;
use Cms\UserManagerBundle\Entity\Repository\UserRepository;


class UserProvider implements UserProviderInterface
{

    protected $userRepository;
    protected $doctrine;

    public function __construct(UserRepository $userRepository, $doctrine){

        $this->userRepository = $userRepository;
        $this->doctrine = $doctrine;

    }

    public function loadUserByUsername($username)
    {

        $fail = true;

        if ($username) {

            $user = $this->userRepository->getUserByUsername($username);

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