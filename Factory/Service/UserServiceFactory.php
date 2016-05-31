<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 24/04/2016
 * Time: 21:09
 */

namespace Oni\UserManagerBundle\Factory\Service;


use Oni\CoreBundle\Factory\CoreAbstractFactory;
use Oni\UserManagerBundle\Service\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserServiceFactory extends CoreAbstractFactory {

	public function getService(ContainerInterface $serviceContainer)
	{

		$encoderFactory = $serviceContainer->get('security.encoder_factory');
		$objectManager  = $serviceContainer->get('doctrine.orm.entity_manager');
		$class = 'Oni\\UserManagerBundle\\Entity\\User';

		$userService = new UserService(
			$encoderFactory,
			$objectManager,
			$class
		);

		return $userService;


	}

}