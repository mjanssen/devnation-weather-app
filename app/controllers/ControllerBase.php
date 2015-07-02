<?php
/**
 * User: marnixjanssen
 * Date: 6/7/15
 */

namespace Devnation\App\Controllers;

use Devnation\App\Models\User\Favorites;
use GeoIp2\Database\Reader;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {

    protected $reader;

    /**
     * Set needed template vars for javascript
     *
     * Get locations for current user (if logged in)
     */
    public function onConstruct()
    {
        $this->view->setLayout('main');

        $basePath = "/";
        $templateDir = APP_PATH . "/public/dist/templates/";

        //Dynamic PHP code that will normally be stored in some kind of controller
        $templateData = array(
            'favorites' => file_get_contents($templateDir . 'favorites.html'),
            'favorite' => file_get_contents($templateDir . 'favorite.html'),
            'location' => file_get_contents($templateDir . 'location.html'),
            'compare' => file_get_contents($templateDir . 'compare.html'),
            'error' => file_get_contents($templateDir . 'error.html')
        );

        $settings = json_encode(array(
            'basePath' => $basePath,
            'templates' => $templateData
        ));

        $this->view->user = ($this->auth->isUserSignedIn()) ? $this->auth->getIdentity() : false;
        $this->view->js_settings = $settings;

        $this->reader = new Reader(APP_PATH . "/app/database/geoip/GeoLite2-City.mmdb");
    }
}