<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 24/04/2016
 * Time: 21:06
 */

namespace Oni\UserManagerBundle\Service;

use Oni\UserManagerBundle\Entity\Repository\GroupRepository;
use Oni\UserManagerBundle\Entity\Repository\UserRepository;
use Oni\UserManagerBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserService implements UserServiceInterface{

	protected $encoderFactory;

	protected $userRepository;

	protected $groupRepository;


	public function __construct(
		EncoderFactoryInterface $encoderFactory,
		UserRepository $userRepository,
		GroupRepository $groupRepository
	)
	{

		$this->encoderFactory = $encoderFactory;
		$this->userRepository = $userRepository;
		$this->groupRepository = $groupRepository;

	}

	public function findByUsername($username)
	{
		return $this->userRepository->findByUsername($username);
	}


	public function findUserBy( array $criteria )
	{
		return  $this->userRepository->findBy($criteria);
	}


	public function getEntityClass()
	{
		return $this->userRepository->getClassName();
	}

	public function getUserHighestAccessLevel(User $user)
	{

		$highestAccessLevel = 1;

		foreach ($user->getGroups() as $group){
			$highestAccessLevel = ($group->getAccessLevel() > $highestAccessLevel) ? $group->getAccessLevel() : $highestAccessLevel;
		}

		return $highestAccessLevel;

	}

}