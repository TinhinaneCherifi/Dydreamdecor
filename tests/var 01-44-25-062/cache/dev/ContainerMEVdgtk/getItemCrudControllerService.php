<?php

namespace ContainerMEVdgtk;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getItemCrudControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\Admin\ItemCrudController' shared autowired service.
     *
     * @return \App\Controller\Admin\ItemCrudController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/vendor/easycorp/easyadmin-bundle/src/Contracts/Controller/CrudControllerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/easycorp/easyadmin-bundle/src/Controller/AbstractCrudController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/Admin/ItemCrudController.php';

        $container->services['App\\Controller\\Admin\\ItemCrudController'] = $instance = new \App\Controller\Admin\ItemCrudController();

        $instance->setContainer(($container->privates['.service_locator.ipvtXDO'] ?? $container->load('get_ServiceLocator_IpvtXDOService'))->withContext('App\\Controller\\Admin\\ItemCrudController', $container));

        return $instance;
    }
}
