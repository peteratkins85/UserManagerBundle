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

	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entityManager;

	public function __construct(ContainerInterface $container) {
		$this->container = $container;
		$this->entityManager = $this->container->get('doctrine.orm.default_entity_manager');
	}

	public static function getSubscribedEvents() {
		return array(
			UserEvents::USER_ADD => 'onUserAdd',
			UserEvents::USER_EDIT => 'onUserEdit',
			UserEvents::USER_DELETE => 'onUserDelete',
		);
	}

	public function persistUser($user){

		$this->entityManager->persist($user);

		$isPersisted = $this->entityManager->contains($user);

		$this->entityManager->flush();

		return $isPersisted;

	}
	
	
	public function onUserAdd(UserEvent $userEvent){

		$user = $userEvent->getUser();

		$this->persistUser($user);

	}

	public function onUserEdit(UserEvent $userEvent){

		$user = $userEvent->getUser();

		$this->persistUser($user);

	}

	public function onUserDelete(UserEvent $userEvent){

		$user = $userEvent->getUser();

		$this->persistUser($user);

	}
	
}