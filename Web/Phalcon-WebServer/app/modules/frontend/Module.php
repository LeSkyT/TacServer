<?php

namespace Frontend;

use Phalcon\Loader;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers the module auto-loader
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces( [
            "Frontend\\Controllers" => $di->getConfig()->application->modulesDir . "/frontend/controllers/",
        ]);

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di) {

        $config = $di->getConfig();

        // Registering a dispatcher
        $di->set(
            "dispatcher",
            function () {
                $dispatcher = new Dispatcher();

                $dispatcher->setDefaultNamespace('Frontend\Controllers\\');

                return $dispatcher;
            }
        );

        $di->get("view")->setViewsDir($config->application->modulesDir . "/frontend/views/");

    }
}
