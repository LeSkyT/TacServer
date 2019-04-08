<?php

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));

use Phalcon\Config;

return new Config(
    [
        'mongo' => [
            'host'      => '127.0.0.1',
            'username'  => null,
            'password'  => null,
            'dbname'    => 'TacServer',
        ],
        'application' => [
            'modelsDir'         => BASE_PATH . '/app/common/models/',
            'controllersDir'    => BASE_PATH . '/app/common/controllers/',
            'modulesDir'        => BASE_PATH . '/app/modules/',
            'libraryDir'        => BASE_PATH . '/app/common/library/',
            'cacheDir'          => BASE_PATH . '/cache/',
            'publicDir'         => BASE_PATH . '/public/',
            'minecraftDir' 		=> BASE_PATH . '/minecraft/',
            'baseUri'           => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"])
        ]
    ]
);
