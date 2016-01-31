<?php
namespace Oni\UserManagerBundle\EventListeners;

use Oni\CoreBundle\SessionKeys;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserEventSubscriber implements EventSubscriberInterface
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
        EntityManager $entityManager,
        ContainerInterface $container
    ){

        $this->em = $entityManager;
        $this->container = $container;

    }

    public static function getSubscribedEvents()
    {
        return array(
            'security.interactive_login' => 'onLoginSuccess'
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
}