<?php
namespace Prison\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Prison\Entity\User;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $user = new User();
        $user->setUsername("dzhibas");
        var_dump($user);
        return new ViewModel();
    }
}
