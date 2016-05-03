<?php

namespace Oni\UserManagerBundle\Factory\Controller;

use Oni\CoreBundle\Factory\CoreAbstractFactory;
use Oni\UserManagerBundle\Controller\UserController;
use Symfony\Component\DependencyInjection\Container;

class UserControllerFactory extends CoreAbstractFactory{

	function getController(Container $serviceContainer){

		$this->setContainer($serviceContainer);

		$userRepository = $this->container->get('oni_user_repository');

		$controller = new UserController(
			$userRepository
		);

		$controller = $this->injectControllerDependencies($controller);

		return $controller;

	}
	

}