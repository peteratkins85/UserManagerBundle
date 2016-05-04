<?php

namespace Oni\UserManagerBundle\Controller;

use Oni\CoreBundle\Controller\CoreController;
use Oni\UserManagerBundle\Entity\Repository\UserRepository;
use Oni\UserManagerBundle\Entity\User;
use Oni\UserManagerBundle\Event\NewUserAddEvent;
use Oni\UserManagerBundle\Event\UserEvent;
use Oni\UserManagerBundle\Form\UserType;
use Oni\UserManagerBundle\UserEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

class UserController extends CoreController
{
    /**
     * @var \Oni\UserManagerBundle\Entity\Repository\UserRepository
     */
    private $usersRepository;

    public function __construct(UserRepository $userRepository) {

        $this->usersRepository = $userRepository;

    }


    public function indexAction()
    {

        $users = $this->usersRepository->getAllUsersAsArray();

        return $this->render('UserManagerBundle:User:index.html.twig',
            array(
                'users' => $users
            )
        );

    }
    
    public function addAction(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access!');

        $user = $this->get('oni_user_entity');

        $userForm = $this->createForm(UserType::class,$user);

        if ($request->isMethod('POST')) {

            $userForm->handleRequest($request);

            if ($userForm->isSubmitted() && $userForm->isValid()) {

                $this->get('oni_event_dispatcher')->dispatch(UserEvents::USER_ADD, new UserEvent($user));

                $this->addFlash('notice',$this->translator->trans('oni_user_bundle.user_added_successfully'));

                return $this->redirectToRoute('oni_user_list');

            }else{

                $this->flashErrors($userForm);

            }

        }

        return $this->render( 'add_edit.html.twig',
            array(
                'pageName' => $this->get('translator')->trans('oni_user_bundle.users'),
                'form' => $userForm->createView()
            )
        );
        
    }

    public function editAction($userId, Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access!');
        $user = $this->usersRepository->find($userId);

        $userForm = $this->createForm(UserType::class,$user);

        if ($request->isMethod('POST')) {

            $userForm->handleRequest($request);

            if ($userForm->isSubmitted() && $userForm->isValid()) {

                $this->get('oni_event_dispatcher')->dispatch(UserEvents::USER_EDIT, new UserEvent($user));

                $this->addFlash('notice',$this->translator->trans('oni_user_bundle.user_update_successfully'));

                return $this->redirectToRoute('oni_user_list');

            }else{

                $this->flashErrors($userForm);

            }

        }

        return $this->render( 'UserManagerBundle:User:add_edit.html.twig',
            array(
                'pageName' => $this->get('translator')->trans('oni_user_bundle.users'),
                'form' => $userForm->createView()
            )
        );

    }

    public function deleteAction($userId, Request $request)
    {

        return $this->render('UserManagerBundle:User:edit.html.twig',
            array(
                'users' => $users
            )
        );

    }

    public function ajaxAction(){



    }

}
