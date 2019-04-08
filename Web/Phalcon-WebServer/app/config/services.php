<?php

use Phalcon\DI\FactoryDefault as DependencyInjector;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new DependencyInjector();

$di->setShared('router', function () {
    return require BASE_PATH . '/app/config/router.php';
});

$di->setShared('config', function () use ($config) {
    return $config;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () use ($config) {
    $url = new Url();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->registerEngines(
        [
            '.volt'  => function ($view, $di) use ($config) {
                $volt = new Phalcon\Mvc\View\Engine\Volt($view, $di);

                $volt->setOptions(
                    [
                        'compiledPath'      => $config->application->cacheDir,
                        'compiledSeparator' => '_'
                    ]
                );

                return $volt;
            },
            // Generate Template files uses PHP itself as the template engine
            '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
        ]
    );

    return $view;
});

/**
 * MongoDb Client Adapter
 */
use Phalcon\Db\Adapter\MongoDB\Client as MongoDbAdapter;
$di->set('mongo', function () use ($config) {

    if (!empty($config->mongo->username) and !empty($config->mongo->password)) {
        $dsn = sprintf(
            'mongodb://%s:%s@%s',
            $config->mongo->username,
            $config->mongo->password,
            $config->mongo->host
        );
    } else {
        $dsn = 'mongodb://' . $config->mongo->host;
    }
    
    $mongo = new MongoDbAdapter($dsn);

    return $mongo->selectDatabase($config->mongo->dbname);
});

/**
 * Collection Manager
 */
use Phalcon\Mvc\Manager as CollectionManager;
$di->setShared('collectionManager', function () {
    return new CollectionManager();
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
use Phalcon\Mvc\Model\Metadata\Memory as ModelsMetadata;
$di->set('modelsMetadata', function () use ($config) {
    return new ModelsMetadata();
});

/**
 * Start the session the first time some component request the session service
 */
use Phalcon\Session\Adapter\Files as Session;
$di->set('session', function () {
    $session = new Session();
    $session->start();

    return $session;
});

use Phalcon\Mvc\Dispatcher;
$di->set('dispatcher', function () {
    $dispatcher = new Dispatcher();

    return $dispatcher;
});
