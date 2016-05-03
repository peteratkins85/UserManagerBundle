<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 02/05/2016
 * Time: 22:32
 */

namespace Oni\UserManagerBundle\EventListeners;


use Oni\UserManagerBundle\Event\UserEvent;
use Oni\UserManagerBundle\UserEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserEventSubscriber implements EventSubscriberInterface{

	/**
	 * @var \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	protected $container;

	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	public static function getSubscribedEvents() {
		return array(
			UserEvents::USER_ADD => 'onUserAdd',
		);
	}
	
	
	public function onUserAdd(UserEvent $userEvent){

		$user = $userEvent->getUser();

	}
	
}