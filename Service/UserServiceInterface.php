<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 24/04/2016
 * Time: 21:54
 */

namespace App\Oni\UserManagerBundle\Service;


interface UserServiceInterface {

	public function findByUsername($username);

	public function findUserBy(array $criteria);

	public function getEntityClass();

	public function findAll();

}