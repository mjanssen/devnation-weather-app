<?php
/**
 * User: marnixjanssen
 * Date: 7/2/15
 */

namespace Devnation\App\Controllers;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class AjaxControllerBase extends Controller {

    protected $response;

    /**
     * Set needed response vars
     */
    public function onConstruct()
    {
        $this->view->disable();

        $this->response = new Response();
        $this->response->setContentType('application/json', 'UTF-8');
    }
}