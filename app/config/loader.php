<?php
/**
 * User: marnixjanssen
 * Date: 6/7/15
 */

use Phalcon\Loader;

$modelsDir      = $config->application->modelsDir;
$controllersDir = $config->application->controllersDir;
$libraryDir     = $config->application->libraryDir;
$routesDir      = $config->application->routesDir;

$loader = new Loader();
/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(
    [
        'Devnation\App\Models'        => $modelsDir,
        'Devnation\App\Controllers'   => $controllersDir,
        'Devnation\App\Library'       => $libraryDir,
        'Devnation\App\Routes'        => $routesDir
    ]
);
$loader->register();