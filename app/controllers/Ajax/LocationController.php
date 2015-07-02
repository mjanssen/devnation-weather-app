<?php
/**
 * User: marnixjanssen
 * Date: 7/1/15
 */

namespace Devnation\App\Controllers\Ajax;

use Devnation\App\Controllers\AjaxControllerBase;

class LocationController extends AjaxControllerBase {

    /**
     * Returns current address information from visitor
     *
     * @return mixed
     */
    public function getAddressAction()
    {
        $longitude = $this->request->getPost('longitude');
        $latitude = $this->request->getPost('latitude');

        $curl     = new \Ivory\HttpAdapter\CurlHttpAdapter();
        $geocoder = new \Geocoder\Provider\GoogleMaps($curl);

        $address = $geocoder->reverse($longitude, $latitude)->first();

        $data = [
            'streetName' => $address->getStreetName(),
            'streetNumber' => $address->getStreetNumber(),
            'country' => [
                'name' => $address->getCountry()->getName(),
                'string' => $address->getCountry()->toString(),
                'code' => $address->getCountry()->getCode()
            ],
            'city' => $address->getLocality(),
            'subCity' => $address->getSubLocality()
        ];

        $this->response->setContent(json_encode($data));

        return $this->response;
    }
}