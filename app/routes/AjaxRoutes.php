<?php
/**
 * User: marnixjanssen
 * Date: 7/2/15
 */

namespace Devnation\App\Routes;

use Phalcon\Mvc\Router\Group as RouterGroup;

class AjaxRoutes extends RouterGroup {

    public function initialize()
    {
        //Default paths
        $this->setPaths([
            'namespace' => 'Devnation\\App\\Controllers\\Ajax'
        ]);

        $this->add("/ajax/weather/city/{city}", ["controller" => "Weather", "action" => "weatherForCity"]);
        $this->add("/ajax/location/getAddress", ["controller" => "Location", "action" => "getAddress"]);
        $this->add("/ajax/user/getFavorites", ["controller" => "User", "action" => "getFavoriteLocations"]);
        $this->add("/ajax/user/setFavorite", ["controller" => "User", "action" => "setFavoriteLocation"]);
        $this->add("/ajax/user/hasFavorite/{city}", ["controller" => "User", "action" => "hasFavorite"]);
        $this->add("/ajax/user/weatherForCurrentLocation", ["controller" => "User", "action" => "weatherForCurrentLocation"]);
    }
}