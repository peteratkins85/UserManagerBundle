<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 16/04/2016
 * Time: 01:04
 */

namespace Oni\UserManagerBundle\Factory\Form;


use Oni\CoreBundle\Factory\CoreAbstractFactory;
use Oni\UserManagerBundle\Form\UserType;
use Symfony\Component\DependencyInjection\Container;

class UserTypeFactory extends CoreAbstractFactory {


	public function getForm(Container $serviceContainer){

		$userService = $serviceContainer->get('oni_user_service');
		$groupRepository = $serviceContainer->get('oni_groups_repository');
		$authenticationToken = $serviceContainer->get('security.token_storage');

		$userForm = new UserType(
			$authenticationToken,
			$userService,
			$groupRepository
		);
		
		return $userForm;

	}

}