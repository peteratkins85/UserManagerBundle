<?php

namespace Oni\UserManagerBundle\Factory\Controller;

use Oni\CoreBundle\Factory\CoreAbstractFactory;
use Oni\UserManagerBundle\Controller\UserController;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserControllerFactory extends CoreAbstractFactory{

	function getService(ContainerInterface $serviceContainer){


		$userService = $serviceContainer->get('oni_user_service');

		$controller = new UserController(
			$userService
		);

        $this->injectCommonDependencies($controller, $serviceContainer);

		return $controller;

	}
	

}