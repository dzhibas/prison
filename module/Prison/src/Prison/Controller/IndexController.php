<?php
namespace Prison\Controller;

use Zend\Http\Response;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        $r = $this->loginRequired();
        if ($r instanceof Response) return $r;

        if ($this->hasIdentity())
        {
            return $this->redirect()->toRoute("prison/team");
        }
    }
}
