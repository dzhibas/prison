<?php
namespace Prison\Collector;

use Zend\Mvc\MvcEvent;
use Zend\View\ViewEvent;
use ZendDeveloperTools\Collector\AbstractCollector;


class ViewCollector extends AbstractCollector
{
    public function getName()
    {
        return "viewvars";
    }

    public function getPriority()
    {
        return PHP_INT_MAX;
    }

    public function collect(MvcEvent $mvcEvent)
    {
        if (!isset($this->data))
        {
            $this->data = array();
            $this->data['vars'] = array();
        }

        $view = $mvcEvent->getViewModel();

        foreach($view->getVariables() as $name => $value)
        {
            if (is_object($value)) {
                $this->data['vars'][$name] = get_class($value);
            } else {
                $this->data['vars'][$name] = $value;
            }
        }

        if ($view->hasChildren()) {
            foreach ($view->getChildren() as $child) {
                foreach($child->getVariables() as $name => $value) {
                    if (is_object($value)) {
                        $this->data['vars'][$name] = get_class($value);
                    } else {
                        $this->data['vars'][$name] = $value;
                    }
                };
            }
        }
    }

    public function getViewVariables()
    {
        return $this->data['vars'];
    }

}