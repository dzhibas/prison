<?php
namespace Prison\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        $this->loginRequired();

        if ($this->hasIdentity())
        {
            return $this->redirect()->toRoute("prison/team");
        }
    }
}
