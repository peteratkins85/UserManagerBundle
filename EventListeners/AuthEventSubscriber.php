<?php
namespace Oni\UserManagerBundle\EventListeners;

use Oni\CoreBundle\Entity\Repository\LanguagesRepository;
use Oni\CoreBundle\SessionKeys;
use Doctrine\ORM\EntityManager;
use Oni\UserManagerBundle\Entity\User;
use Oni\UserManagerBundle\Event\NewUserAddEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Oni\UserManagerBundle\Entity\UserInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthEventSubscriber implements EventSubscriberInterface
{

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var LanguagesRepository
     */
    protected $languageRepository;

    /**
     * AuthEventSubscriber constructor.
     * @param Session $session
     * @param $entityManager
     * @param LanguagesRepository $languagesRepository
     */
    public function __construct(
        Session $session,
        $entityManager,
        LanguagesRepository $languagesRepository
    ){
        $this->session = $session;
        $this->em = $entityManager;
        $this->languageRepository = $languagesRepository;
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
        
        if ($user instanceof User) {


            $language = $this->languageRepository->getDefaultLanguage();

            if ( $language ) {
                $this->session->set( SessionKeys::LOCALE_KEY,
                    $language->getLocale() );
            }

            if ( $user instanceof UserInterface ) {

                $now = new \DateTime();
                $user->setLastlogin( $now );
                $user->setLoggedInn( $user->getLoggedInn() + 1 );
                $this->em->flush();

            }
            
        }

    }

}