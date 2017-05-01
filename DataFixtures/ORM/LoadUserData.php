<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 25/12/15
 * Time: 19:42
 */

namespace Oni\UserManagerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Oni\UserManagerBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Oni\UserManagerBundle\Entity\Group;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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
        $userGroup1 = new Group();
        $userGroup1->setName('Web User');
        $userGroup1->setRoles(['ROLE_ONI_WEB_USER']);

        $userGroup2 = new Group();
        $userGroup2->setName('Standard User');
        $userGroup2->setRoles(['ROLE_ONI_USER']);

        $userGroup3 = new Group();
        $userGroup3->setName('Admin');
        $userGroup3->setRoles(['ROLE_ONI_ADMIN']);

        $userGroup4 = new Group();
        $userGroup4->setName('Super Admin');
        $userGroup4->setRoles(['ROLE_ONI_SUPER_ADMIN']);

        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $acl = $this->container->get('security.acl.provider');

        $em->persist($userGroup1);
        $em->persist($userGroup2);
        $em->persist($userGroup3);
        $em->persist($userGroup4);
        $em->flush();

        //Super Admin User
        $user = new User();
        $user->setActive(1);
        $user->setCreated(new \DateTime('now'));
        $user->setCredentialsExpireAt(new \DateTime('+ 2 years'));
        $user->setCredentialsExpired(0);
        $user->setEmail('admin@cmstest.com');
        $user->setExpired(0);
        $user->addGroup($userGroup4);
        $password = $this->container->get('security.password_encoder')->encodePassword($user, 'admin');
        $user->setPassword($password);
        $user->setUsername('admin');
        $user->setPlainPassword('admin');
        $user->setExpiresAt(new \DateTime('+ 2 years'));
        $user->setEnabled(1);

        //Standard User
        $user2 = new User();
        $user2->setActive(1);
        $user2->setCreated(new \DateTime('now'));
        $user2->setCredentialsExpireAt(new \DateTime('+ 2 years'));
        $user2->setCredentialsExpired(0);
        $user2->setEmail('user@cmstest.com');
        $user2->setExpired(0);
        $password2 = $this->container->get('security.password_encoder')->encodePassword($user2, 'user');
        $user2->setPassword($password2);
        $user2->addGroup($userGroup2);
        $user2->setUsername('user');
        $user2->setPlainPassword('user');
        $user2->setExpiresAt(new \DateTime('+ 2 years'));
        $user2->setEnabled(1);

        //Standard User
        $user2 = new User();
        $user2->setActive(1);
        $user2->setCreated(new \DateTime('now'));
        $user2->setCredentialsExpireAt(new \DateTime('+ 2 years'));
        $user2->setCredentialsExpired(0);
        $user2->setEmail('user@cmstest.com');
        $user2->setExpired(0);
        $password2 = $this->container->get('security.password_encoder')->encodePassword($user2, 'user');
        $user2->setPassword($password2);
        $user2->addGroup($userGroup2);
        $user2->setUsername('user');
        $user2->setPlainPassword('user');
        $user2->setExpiresAt(new \DateTime('+ 2 years'));
        $user2->setEnabled(1);

        $em->persist($user);
        $em->persist($user2);
        $em->flush();

        $oid = new ObjectIdentity('class', User::class);
        $superAdminGroup = new RoleSecurityIdentity(current($userGroup4->getRoles()));
        $userIdentity = new UserSecurityIdentity($user, User::class);
        $webUserGroup = new RoleSecurityIdentity(current($userGroup1->getRoles()));
        $userGroup = new RoleSecurityIdentity(current($userGroup2->getRoles()));
        $adminGroup = new RoleSecurityIdentity(current($userGroup3->getRoles()));

        try {
            $aclProvider = $acl->createAcl($oid);
        } catch (\Exception $e) {
            $aclProvider = $acl->findAcl($oid);
        }

        $aclProvider->insertClassAce($userIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->insertClassAce($superAdminGroup, MaskBuilder::MASK_MASTER);
        $aclProvider->insertClassAce($userGroup, MaskBuilder::MASK_EDIT);
        $aclProvider->insertClassAce($adminGroup, MaskBuilder::MASK_MASTER);


        $acl->updateAcl($aclProvider);
        $this->addReference('user', $user);
    }

    public function getOrder()
    {
        return 2;
    }
}
