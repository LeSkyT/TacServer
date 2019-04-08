<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs([
	$config->application->modelsDir,
	$config->application->controllersDir,
]);

/**
 * Libraries
 */
$loader->registerNamespaces([
	'Phalcon' => $config->application->libraryDir . '/incubator/Library/Phalcon/', // Incubator
	//More
]);

$loader->register();