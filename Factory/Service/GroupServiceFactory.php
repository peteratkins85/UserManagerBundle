<?php

namespace App\Oni\UserManagerBundle\Factory\Service;


use App\Oni\CoreBundle\Factory\CoreAbstractFactory;
use App\Oni\UserManagerBundle\Service\GroupService;
use App\Oni\UserManagerBundle\Service\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GroupServiceFactory extends CoreAbstractFactory {

    /**
     * @param ContainerInterface $serviceContainer
     * @return UserService
     */
	public function getService(ContainerInterface $serviceContainer)
	{

		$encoderFactory = $serviceContainer->get('security.encoder_factory');
		$objectManager  = $serviceContainer->get('doctrine.orm.entity_manager');
		$class = 'Oni\\UserManagerBundle\\Entity\\Group';

		$groupService = new GroupService(
			$encoderFactory,
			$objectManager,
			$class
		);

		return $groupService;

	}

}