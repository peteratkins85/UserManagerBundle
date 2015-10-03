<?php

namespace Cms\UserManagerBundle\Controller;

use Cms\UserManagerBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Cms\UserManagerBundle\Form\User\Login;


class UserController extends Controller
{
    
    public function loginAction(Request $request)
    {

        $session = $request->getSession();
        
        $form = $this->createForm(new Login(), null, array(
            'action' => $this->generateUrl('login_check'),
        ));

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        return $this->render('UserManagerBundle:Login:index.html.twig', array(
            'form' => $form->createView(),
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
        
    }
    
}
