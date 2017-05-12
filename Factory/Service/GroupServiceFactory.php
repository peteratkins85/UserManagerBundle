<?php

namespace Oni\UserManagerBundle\Factory\Service;


use Oni\CoreBundle\Factory\CoreAbstractFactory;
use Oni\UserManagerBundle\Service\GroupService;
use Oni\UserManagerBundle\Service\UserService;
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