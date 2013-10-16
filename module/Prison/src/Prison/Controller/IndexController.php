<?php
namespace Prison\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected function login_required()
    {
        $auth = $this->getServiceLocator()->get('zfcuser_auth_service');
        if (!$auth->hasIdentity()) {
            return $this->redirect()->toUrl(
                $this->url()->fromRoute("zfcuser/login") .
                "?redirect=" . urlencode($this->url()->fromRoute("home")));
        }
    }

    public function indexAction()
    {
        $this->login_required();
        return new ViewModel();
    }
}
