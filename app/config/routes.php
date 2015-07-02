<?php
/**
 * User: marnixjanssen
 * Date: 6/7/15
 */

use Phalcon\Mvc\Router;
use Devnation\App\Routes\UserRoutes;
use Devnation\App\Routes\AjaxRoutes;

$router = new Router(false);
$router->setDefaultNamespace("Devnation\\App\\Controllers\\Main");

$router->add("/", ["controller" => "Index", "action" => "index"])->setName("home");
$router->add("/info/{city:[a-z\-]+}", ["controller" => "Index", "action" => "index"]);

$router->mount(new UserRoutes());
$router->mount(new AjaxRoutes());
//$router->add("/ajax/weather/city/{city}", ["namespace" => "Devnation\\App\\Controllers\\Ajax", "controller" => "Weather", "action" => "weatherForCity"]);
//$router->add("/ajax/location/getAddress", ["namespace" => "Devnation\\App\\Controllers\\Ajax", "controller" => "Location", "action" => "getAddress"]);
//$router->add("/ajax/user/getFavorites", ["namespace" => "Devnation\\App\\Controllers\\Ajax", "controller" => "User", "action" => "getFavoriteLocations"]);
//$router->add("/ajax/user/setFavorite", ["namespace" => "Devnation\\App\\Controllers\\Ajax", "controller" => "User", "action" => "setFavoriteLocation"]);
//$router->add("/ajax/user/hasFavorite/{city}", ["namespace" => "Devnation\\App\\Controllers\\Ajax", "controller" => "User", "action" => "hasFavorite"]);
//$router->add("/ajax/user/weatherForCurrentLocation", ["namespace" => "Devnation\\App\\Controllers\\Ajax", "controller" => "User", "action" => "weatherForCurrentLocation"]);

return $router;