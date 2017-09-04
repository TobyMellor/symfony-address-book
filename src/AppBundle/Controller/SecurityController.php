<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseSecurityController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseSecurityController {
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return new RedirectResponse($this->generateUrl('homepage'));
        }
        
        return parent::loginAction($request);
    }
}