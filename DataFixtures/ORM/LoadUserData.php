<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 25/12/15
 * Time: 19:42
 */

namespace Cms\ProductManagerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Cms\UserManagerBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface ,FixtureInterface, ContainerAwareInterface
{


    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function load(ObjectManager $manager)
    {

        $startDate = time();

        $user = new User();
        $user->setActive(1);
        $user->setCreated(new \DateTime('now'));
        $user->setCredentialsExpireAt(new \DateTime('+ 2 years'));
        $user->setCredentialsExpired(0);
        $user->setEmail('admin@cmstest.com');
        $user->setExpired(0);
        $password = $this->container->get('security.password_encoder')->encodePassword($user,'admin');
        $user->setPassword($password);
        $user->setUsername('admin');
        $user->setPlainPassword('admin');
        $user->setExpiresAt(new \DateTime('+ 2 years'));
        $user->setRoles('ROLE_ADMIN');
        $user->setEnabled(1);

        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $em->persist($user);
        $em->flush();

        $this->addReference('user', $user);

    }

    public function getOrder()
    {
        return 2;
    }
}
