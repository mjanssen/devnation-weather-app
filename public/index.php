<?php
/**
 * User: marnixjanssen
 * Date: 6/7/15
 */

use Phalcon\Loader;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;

error_reporting(E_ALL);

define('APP_PATH', realpath('..'));

/**
 * Include composer autoloader
 */
require APP_PATH . "/app/vendor/autoload.php";

try {

    $config = include APP_PATH . "/app/config/config.php";

    require APP_PATH . "/app/config/loader.php";

    /**
     * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
     */
    $di = new FactoryDefault();

    /**
     * Include the application services
     */
    require APP_PATH . "/app/config/services.php";

    require APP_PATH . "/app/config/userPluginServices.php";

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch(\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}