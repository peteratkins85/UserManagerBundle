<?php
namespace Oni\UserManagerBundle\EventListeners;

use Oni\CoreBundle\SessionKeys;
use Doctrine\ORM\EntityManager;
use Oni\UserManagerBundle\Event\NewUserAddEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Oni\UserManagerBundle\Entity\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oni\UserManagerBundle\UserEvents;

class AuthEventSubscriber implements EventSubscriberInterface
{

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * UserEventSubscriber constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        ContainerInterface $container
    ){

        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
        
    }

    public static function getSubscribedEvents()
    {
        return array(
            'security.interactive_login' => 'onLoginSuccess',
        );
    }

    public function onLoginSuccess(Event $event)
    {

        $token = $event->getAuthenticationToken();
        $user = $token->getUser();
        $session = $this->container->get('session');
        $languageRepository = $this->container->get('oni_language_repository');
        $language = $languageRepository->getDefaultLanguage();

        if ($language) {
            $session->set(SessionKeys::LOCALE_KEY, $language->getLocale());
        }

        if ($user instanceof UserInterface){

            $now = new \DateTime();
            $user->setLastlogin($now);
            $user->setLoggedInn($user->getLoggedInn()+1);
            $this->em->flush();

        }

    }

    public function onUserAdd(NewUserAddEvent $event)
    {



    }

}