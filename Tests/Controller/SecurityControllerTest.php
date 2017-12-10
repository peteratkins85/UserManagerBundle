<?php

namespace Tests\UserManagerBundle\Controller;

use App\Oni\CoreBundle\Tests\CoreTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityControllerTest extends WebTestCase{

	/**
	 * @var
	 */
	private $client;

	public function setUp()
	{
		$this->client = static::createClient();
	}


	public function testLogin()
	{

//		$client = static::createClient();
//	$client->getResponse()->isSuccessful()
//		$hostname = $this->getHost();
//
//		$this->client->request('GET', $hostname.'/admin/login');
//
//		$this->assertTrue($this->client->getResponse()->isSuccessful());

	}


}