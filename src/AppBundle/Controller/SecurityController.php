<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
    public function loginAction(Request $request)
    {
        if ($this->getUser()) {
            return $this->redirect($request->getSession()->get('_security.main.target_path'));
        }

        return parent::loginAction($request);
    }
}
