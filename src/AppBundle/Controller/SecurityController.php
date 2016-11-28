<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
    public function loginAction(Request $request)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('paciente_index');
        }

        return parent::loginAction($request);
    }
}
