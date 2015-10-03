<?php

namespace Cms\UserManagerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
//for extending the fos SecurityContoller
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\Security\Core\SecurityContextInterface;
//use DataLayer\DataHandler;


class SecurityController extends BaseController
{

     public function loginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();
        $securityContext = $this->container->get('security.context');

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        return $this->renderLogin(array(
            'pageName' => 'CMS Login',
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    /***
     *
     * For multipl site
     * This was for CMS remote access project
     *
     */
    public function siteSelectAction(Request $request)
    {

        $session = $request->getSession();
        $siteSet = $session->get('siteSet');
        $securityContext = $this->container->get('security.context');

        if ($siteSet){

            return $this->redirect($this->generateUrl('cms/'));

        }

        //Check if logged in via remember key
        if( $securityContext->isGranted('IS_AUTHENTICATED_FULLY') ){

            return $this->container->get('templating')->renderResponse('UserManagerBundle:Security:site_select.html.twig', array());

        }else{

            return $this->redirect($this->generateUrl('login'));

        }

    }

    public function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }



}
