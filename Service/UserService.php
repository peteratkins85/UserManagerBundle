<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 24/04/2016
 * Time: 21:06
 */

namespace App\Oni\UserManagerBundle\Service;


use App\Oni\UserManagerBundle\Entity\Repository\GroupRepository;
use App\Oni\UserManagerBundle\Entity\Repository\UserRepository;
use App\Oni\UserManagerBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use App\Oni\CoreBundle\Doctrine\Spec\AsObject;
use App\Oni\UserManagerBundle\Doctrine\Spec\FilterUsername;
use Doctrine\Common\Persistence\ObjectManager;

class UserService implements UserServiceInterface
{

    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $userRepository;

    /**
     * @var string
     */
    protected $class;


    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        ObjectManager $objectManager,
        $class
    ) {

        $this->encoderFactory = $encoderFactory;
        $this->userRepository = $objectManager->getRepository($class);

        $metadata = $objectManager->getClassMetadata($class);
        $this->class = $metadata->getName();


    }

    public function findByUsername($username)
    {
        return $this->userRepository->findOneBy(['username' => $username]);
    }

    public function findById($id)
    {
        return $this->userRepository->findOneBy(['id' => $id]);
    }


    public function findUserBy(array $criteria)
    {
        return $this->userRepository->findBy($criteria);
    }

    public function findAll()
    {

        return $this->userRepository->findAll();

    }


    public function getEntityClass()
    {
        return $this->userRepository->getClassName();
    }

    public function getUserHighestAccessLevel(User $user)
    {

        $highestAccessLevel = 1;

        foreach ($user->getGroups() as $group) {
            $highestAccessLevel = ($group->getAccessLevel() > $highestAccessLevel) ? $group->getAccessLevel() : $highestAccessLevel;
        }

        return $highestAccessLevel;

    }

}