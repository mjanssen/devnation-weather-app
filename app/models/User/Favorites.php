<?php
/**
 * User: marnixjanssen
 * Date: 7/2/15
 */

namespace Devnation\App\Models\User;

use Phalcon\Mvc\Model;

class Favorites extends Model {

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $user_id;

    /**
     *
     * @var string
     */
    protected $location_id;

    /**
     *
     * @var string
     */
    protected $name;

    public function initialize()
    {
        $this->setSource("user_favorite_locations");
    }

    public function setLocationId($id)
    {
        $this->location_id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setUserId($id)
    {
        $this->user_id = $id;
    }

    public function getLocationId()
    {
        return $this->location_id;
    }
}