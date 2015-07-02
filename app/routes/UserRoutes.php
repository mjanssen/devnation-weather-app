<?php
/**
 * User: marnixjanssen
 * Date: 7/1/15
 */

namespace Devnation\App\Routes;

use Phalcon\Mvc\Router\Group as RouterGroup;

class UserRoutes extends RouterGroup {

    public function initialize()
    {
        //Default paths
        $this->setPaths([
            'namespace' => 'Devnation\\App\\Controllers\\Main'
        ]);

        $this->add("/user/oauth2callbackuser/loginWithGoogle", ["controller" => "User", "action" => "loginWithGoogle"]);
        $this->add("/user", ["controller" => "User", "action" => "index"]);
        $this->add("/user/login", ["controller" => "User", "action" => "login"])->setName('login');
        $this->add("/user/login/oauth/google", ["controller" => "User", "action" => "loginWithGoogle"]);
        $this->add("/user/profile", ["controller" => "User", "action" => "profile"])->setName('profile');
        $this->add("/user/logout", ["controller" => "User", "action" => "signout"]);
    }
}