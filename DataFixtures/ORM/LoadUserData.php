<?php

/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 14/12/2015
 * Time: 19:00
 */
namespace Cms\UserManagerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cms\UserManagerBundle\Entity\User;


class LoadUserData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword('test');

        $manager->persist($userAdmin);
        $manager->flush();
    }

}