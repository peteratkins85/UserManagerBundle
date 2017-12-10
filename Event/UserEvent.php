<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 24/04/2016
 * Time: 11:32
 */

namespace Oni\UserManagerBundle\Event;

use Oni\UserManagerBundle\Entity\UserInterface;

use Oni\UserManagerBundle\UserEvents;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event {

	const NAME = UserEvents::USER_EVENT;

	protected $user;

	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	public function getUser()
	{
		return $this->user;
	}

}