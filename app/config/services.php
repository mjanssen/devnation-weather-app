<?php
/**
 * User: marnixjanssen
 * Date: 6/7/15
 */

use Phalcon\Mvc\View;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Url;
use Devnation\App\Library\Mail;

/**
 * Register Whoops error handler
 */
new Whoops\Provider\Phalcon\WhoopsServiceProvider($di);

/**
 * The URL component is used to generate all kind of urls in the application
 */
// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set('url', function(){
    $url = new Url();
    $url->setBaseUri('/');
    return $url;
});

/**
 * Setting up volt
 */
$di->set(
    'volt',
    function ($view, $di) use ($config) {
        $volt = new Volt($view, $di);
        $volt->setOptions(
            array(
                "compiledPath"      => APP_PATH . "/app/cache/volt/",
                "compiledSeparator" => "_",
                "compileAlways"     => $config->application->debug
            )
        );
        $volt->getCompiler()->addFunction('number_format', function ($resolvedArgs) {
            return 'number_format(' . $resolvedArgs . ')';
        });
        return $volt;
    },
    true
);

/**
 * Setting up the view component
 */
$di->set(
    'view',
    function () use ($config) {
        $view = new View();
        $view->setViewsDir($config->application->viewsDir);
        $view->registerEngines(
            array(
                ".volt" => 'volt'
            )
        );
        return $view;
    },
    true
);

/**
 * Start the session the first time some component request the session service
 */
$di->set(
    'session',
    function () {
        $session = new SessionAdapter();
        $session->start();
        return $session;
    },
    true
);

//require "";
//
//$di->set('mail', function(){
//    return new Mail();
//});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter($config->database->toArray());
//    return new DbAdapter([
//        'host' => $config->database->host,
//        'username' => $config->database->username,
//        'password' => base64_decode($config->database->password),
//        'dbname' => $config->database->dbname
//    ]);
});


/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set(
    'flashSession',
    function () {
        return new Phalcon\Flash\Session(array(
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info',
        ));
    }
);

/**
 * Router
 */
$di->set(
    'router',
    function () {
        return include APP_PATH . "/app/config/routes.php";
    },
    true
);

/**
 * Set dispatcher
 */
$di->set(
    'dispatcher',
    function () {
        $dispatcher = new MvcDispatcher();
        $dispatcher->setDefaultNamespace('Devnation\App\Controllers');
        return $dispatcher;
    },
    true
);

/**
 * View cache
 */
$di->set(
    'viewCache',
    function () use ($config) {
        if ($config->application->debug) {
            $frontCache = new FrontendNone();
            return new MemoryBackend($frontCache);
        } else {
            //Cache data for one day by default
            $frontCache = new FrontendOutput(array(
                "lifetime" => 86400 * 30
            ));
            return new FileCache($frontCache, array(
                "cacheDir" => APP_PATH . "/app/cache/views/",
                "prefix"   => "devnation-cache-"
            ));
        }
    }
);



$di->set('config', $config);