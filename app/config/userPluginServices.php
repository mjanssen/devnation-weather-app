<?php
/**
 * User: marnixjanssen
 * Date: 7/1/15
 */

$di['dispatcher'] = function() use ($di) {
    $eventsManager = $di->getShared('eventsManager');
    $security = new \Phalcon\UserPlugin\Plugin\Security($di);
    $eventsManager->attach('dispatch', $security);

    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
};

$di['auth'] = function(){
    return new \Phalcon\UserPlugin\Auth\Auth();
};

$di['acl'] = function() {
    return new \Phalcon\UserPlugin\Acl\Acl();
};

$di['mail'] = function() {
    return new \Phalcon\UserPlugin\Mail\Mail();
};