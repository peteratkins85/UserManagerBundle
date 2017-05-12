<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 02/05/2016
 * Time: 22:32
 */

namespace Oni\UserManagerBundle\EventListeners;


use Doctrine\ORM\EntityManager;
use Oni\CoreBundle\Service\FlashMessageService;
use Oni\UserManagerBundle\Event\UserEvent;
use Oni\UserManagerBundle\UserEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class UserEventSubscriber implements EventSubscriberInterface{

	/**
	 * @var \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	protected $container;

	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entityManager;

	/**
	 * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
	 */
	protected $eventDispatcher;

	/**
	 * @var \Oni\CoreBundle\Service\FlashMessageService
	 */
	protected $flashMessageService;

	public function __construct(ContainerInterface $container,
		EventDispatcherInterface $eventDispatcher,
		EntityManager $entityManager,
		FlashMessageService $flashMessageService
	) {
		$this->entityManager = $entityManager;
		$this->eventDispatcher = $eventDispatcher;
		$this->flashMessageService = $flashMessageService;
	}

	public static function getSubscribedEvents()
	{
		return array(
			UserEvents::USER_ADD => 'onUserAdd',
			UserEvents::USER_EDIT => 'onUserEdit',
			UserEvents::USER_DELETE => 'onUserDelete',
		);
	}

	public function persistUser($user)
	{

		$this->entityManager->persist($user);

		$isPersisted = $this->entityManager->contains($user);

		$this->entityManager->flush();

		return $isPersisted;

	}
	
	
	public function onUserAdd(UserEvent $userEvent)
	{

		$user = $userEvent->getUser();

		if ($this->persistUser($user)){



		}

	}

	public function onUserEdit(UserEvent $userEvent)
	{

		$user = $userEvent->getUser();

		if ($this->persistUser($user)){

			$this->flashMessageService->addFlash('notice', 'oni_user_bundle.user_added_successfully');

		}

	}

	public function onUserDelete(UserEvent $userEvent)
	{

		$user = $userEvent->getUser();

		if ($this->persistUser($user)){

			$this->flashMessageService->addFlash('notice', 'oni_user_bundle.user_update_successfully');

		}

	}


}