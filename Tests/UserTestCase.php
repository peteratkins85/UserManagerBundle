<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 05/05/2016
 * Time: 08:27
 */

namespace Oni\UserManagerBundle\Tests;


use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait UserTestCase  {

	protected function logIn()
	{
		$session = $this->client->getContainer()->get('session');

		$firewall = 'cms';
		$token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
		$session->set('_security_'.$firewall, serialize($token));
		$session->save();

		$cookie = new Cookie($session->getName(), $session->getId());
		$this->client->getCookieJar()->set($cookie);
	}

}