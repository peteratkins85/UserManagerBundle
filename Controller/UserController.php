<?php

namespace App\Oni\UserManagerBundle\Controller;

use App\Oni\CoreBundle\Controller\CoreController;
use App\Oni\UserManagerBundle\Entity\Repository\UserRepository;
use App\Oni\UserManagerBundle\Entity\User;
use App\Oni\UserManagerBundle\Event\NewUserAddEvent;
use App\Oni\UserManagerBundle\Event\UserEvent;
use App\Oni\UserManagerBundle\Form\UserType;
use App\Oni\UserManagerBundle\Service\UserServiceInterface;
use App\Oni\UserManagerBundle\UserEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

class UserController extends CoreController
{

    /**
     * @var \App\Oni\UserManagerBundle\Controller\UserService
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {

        $this->userService = $userService;

    }


    public function indexAction()
    {
        
        $users = $this->userService->findAll();

        return $this->render('UserManagerBundle:User:index.html.twig',
            array(
                'users' => $users
            )
        );

    }
    
    public function addAction(Request $request)
    {

        $user = $this->get('oni_user_entity');

        $userForm = $this->createForm(UserType::class,$user);

        if ($request->isMethod('POST')) {

            $userForm->handleRequest($request);

            if ($userForm->isSubmitted() && $userForm->isValid()) {

                $this->get('oni_event_dispatcher')->dispatch(UserEvents::USER_ADD, new UserEvent($user));

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
        $user = $this->userService->findById($userId);

        $userForm = $this->createForm(UserType::class,$user);

        if ($request->isMethod('POST')) {

            $userForm->handleRequest($request);

            if ($userForm->isSubmitted() && $userForm->isValid()) {

                $this->get('oni_event_dispatcher')->dispatch(UserEvents::USER_EDIT, new UserEvent($user));

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

        return $this->render('UserManagerBundle:User:edit.html.twig');

    }

    public function ajaxAction(){



    }

}
