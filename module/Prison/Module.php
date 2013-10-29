<?php
namespace Prison;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use \Prison\Listener\ServiceManagerListener;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $e->getApplication()->getServiceManager();
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');
        $dem = $entityManager->getEventManager();
        $dem->addEventListener(array(\Doctrine\ORM\Events::postLoad), new ServiceManagerListener($serviceManager));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
