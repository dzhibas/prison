<?php
namespace Prison\Controller;
use Zend\Mvc\Controller\AbstractActionController;


class AbstractController extends AbstractActionController
{
    protected function loginRequired()
    {
        $auth = $this->getServiceLocator()->get('zfcuser_auth_service');
        if (!$auth->hasIdentity()) {
            return $this->redirect()->toUrl(
                $this->url()->fromRoute("zfcuser/login") .
                "?redirect=" . urlencode($this->url()->fromRoute("home")));
        }
    }

    protected function getIdentity()
    {
        $auth = $this->getServiceLocator()->get('zfcuser_auth_service');
        return $auth->getIdentity();
    }
} 