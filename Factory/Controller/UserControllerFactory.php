<?php

namespace Oni\UserManagerBundle\Factory\Controller;

use Oni\CoreBundle\Factory\CoreAbstractFactory;
use Oni\UserManagerBundle\Controller\UserController;
use Symfony\Component\DependencyInjection\Container;

class UserControllerFactory extends CoreAbstractFactory{

	function getService(Container $serviceContainer){

		$this->setContainer($serviceContainer);

		$userService = $this->container->get('oni_user_service');

		$controller = new UserController(
			$userService
		);

		$controller = $this->injectControllerDependencies($controller);

		return $controller;

	}
	

}