<?php

namespace App\Oni\UserManagerBundle\Factory\Controller;

use App\Oni\CoreBundle\Factory\CoreAbstractFactory;
use App\Oni\UserManagerBundle\Controller\UserController;
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