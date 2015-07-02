<?php
/**
 * User: marnixjanssen
 * Date: 7/2/15
 */

namespace Devnation\App\Controllers\Ajax;

use Devnation\App\Controllers\AjaxControllerBase;
use Devnation\App\Library\Weather\Weather;
use Devnation\App\Models\User\Favorites;

class UserController extends AjaxControllerBase {

    /**
     * Returns the favorite locations for current user
     *
     * @return mixed
     */
    public function getFavoriteLocationsAction()
    {
        $this->view->disable();
        $user_id = ($this->auth->isUserSignedIn()) ? $this->auth->getIdentity()['id'] : 17; // $this->request->getPost('user_id');

        $favorites = Favorites::find(['user_id = :user_id:', 'bind' => ['user_id' => $user_id]]);

        $ids = [];
        foreach ($favorites as $f) {
            $ids[] = $f->getLocationId();
        }

        $weather = new Weather();
        $cityVars = $weather->getCitiesInfo($ids);

        $cities = json_decode($cityVars);

        $result = [];
        foreach ($cities->list as $key => $city) {
            $result[$key]['city'] = $city->name;
            $result[$key]['temperature'] = $city->main->temp;
            $result[$key]['icon'] = $city->weather[0]->icon;
        }

        $this->response->setContent(json_encode($result));
        return $this->response;
    }

    /**
     * Saves a location for current user
     *
     * @return bool
     */
    public function setFavoriteLocationAction()
    {
        $location_name = $this->request->getPost('location_name');
        $location_id = $this->request->getPost('location_id');

        if ($this->auth->isUserSignedIn() && $location_name && $location_id) {

            $user = $this->auth->getIdentity();

            $location = Favorites::findFirst([
                'name = :name: AND user_id = :user_id:',
                'bind' => ['name' => $location_name, 'user_id' => $user['id']]
            ]);

            if ($location == false) {

                $favorite = new Favorites();
                $favorite->setUserId($user['id']);
                $favorite->setLocationId($location_id);
                $favorite->setName($location_name);

                if ($favorite->save()) {
                    return true;
                }
            }
        }
    }

    /**
     * Checks if user has location
     *
     * @return true | false
     */
    public function hasFavoriteAction()
    {
        $city = $this->dispatcher->getParam("city");

        if ($this->auth->isUserSignedIn()) {

            $user = $this->auth->getIdentity();

            $location = Favorites::findFirst([
                'name = :name: AND user_id = :user_id:',
                'bind' => ['name' => $city, 'user_id' => $user['id']]
            ]);

            $result = ($location) ? true : false;

            $this->response->setContent(json_encode($result));
            return $this->response;
        }
    }

    /**
     * Retrieves weather for current location from user
     *
     * @return mixed
     */
    public function weatherForCurrentLocationAction()
    {
        $longitude = $this->request->getPost('longitude');
        $latitude = $this->request->getPost('latitude');

        if ($longitude != 0 && $latitude != 0) {

            $curl = new \Ivory\HttpAdapter\CurlHttpAdapter();
            $geocoder = new \Geocoder\Provider\GoogleMaps($curl);

            $address = $geocoder->reverse($longitude, $latitude)->first();

            $city = $address->getLocality();

            $weather = new Weather();

            $cityVars = json_decode($weather->getCityVars($city));

            $this->response->setContent(json_encode($cityVars));
            return $this->response;
        }
    }
}