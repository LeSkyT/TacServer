<?php

use Phalcon\Mvc\Application;
use Frontend\Module as FrontendModule;
use Backend\Module as BackendModule;

error_reporting(E_ALL);

try {

    /**
     * Read the configuration
     */
    $config = include __DIR__ . "/../app/config/config.php";

    /**
     * Add Class Autoloader
     */
    include __DIR__ . "/../app/config/loader.php";

    /**
     * Register the services
     */
    include __DIR__ . "/../app/config/services.php";

    /**
     * Create application
     */
    $application = new Application($di);

    // Register the installed modules
    $application->registerModules(
        [
            "frontend" => [
                "className" => FrontendModule::class,
                "path"      => $config->application->modulesDir . "/frontend/Module.php",
            ],
            "backend" => [
                "className" => BackendModule::class,
                "path"      => $config->application->modulesDir . "/backend/Module.php",
            ],
        ]
    );

    /**
     * Handle the request
     */
    $response = $application->handle();

    echo $response->getContent();
} catch(\Exception $e) {
    echo '<h1> Error : </h1>';
    echo '<br />';
    echo '<pre>' . $e . '</pre>';
}