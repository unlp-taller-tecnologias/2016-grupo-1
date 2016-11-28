<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        if ($this->getUser()) {
            return $this->redirect('/');
        }

        return parent::registerAction($request);
    }
}
