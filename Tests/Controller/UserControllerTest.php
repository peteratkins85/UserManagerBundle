<?php

namespace Oni\UserManagerBundle\Tests\Controller;



use Oni\CoreBundle\Tests\CoreTestCase;
use Oni\UserManagerBundle\Tests\UserTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase{

    use CoreTestCase, UserTestCase;

    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function urlProvider()
    {

        $hostname = $this->getHost();

        return array(
            array($hostname.'/admin/users'),
            array($hostname.'/admin/users/add'),
            array($hostname.'/admin/users/edit/1'),
        );
    }

    /**
     * @dataProvider urlProvider
     */
    public function testUserController($url)
    {
        $hostname = $this->getHost();
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isRedirect($hostname.'/admin/login'));
    }

    public function testSecuredIndexAction()
    {

        $this->logIn();

        $hostname = $this->getHost();

        $this->client->request('GET', $hostname.'/admin/users');

        $this->assertTrue($this->client->getResponse()->isSuccessful());

    }



}