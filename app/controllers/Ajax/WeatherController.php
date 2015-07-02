<?php
/**
 * User: marnixjanssen
 * Date: 6/9/15
 */

namespace Devnation\App\Controllers\Ajax;

use Devnation\App\Controllers\AjaxControllerBase;
use Devnation\App\Library\Weather\Weather;

class WeatherController extends AjaxControllerBase {

    /**
     * @return mixed
     */
    public function weatherForCityAction()
    {
        $city = $this->dispatcher->getParam("city");

        $weather = new Weather();

        $cityVars = json_decode($weather->getCityVars($city));

        $forecast = $weather->getWeatherForCity($city, 7);

        $result = [];

        $count = 0;

        foreach ($forecast as $key => $f) {

            /**
             * @var \DateTime $from
             * @var \DateTime $sunRise
             * @var \DateTime $sunSet
             * @var \DateTime $lastUpdate
             */

            $from = $f->time->from;
            $sunRise = $f->sun->rise;
            $sunSet = $f->sun->set;
            $lastUpdate = $f->lastUpdate;

            $result[$count] = [
                'day' => $from->format('l'),
                'date' => $from->format('Y-m-d'),
                'city' => [
                    'name' => $f->city->name,
                    'country' => $f->city->country
                ],
                'temperature' => [
                    'now' => [
                        'value' => $f->temperature->now->getValue(),
                        'unit' => $f->temperature->now->getUnit(),
                        'description' => $f->temperature->now->getDescription()
                    ],
                    'min' => [
                        'value' => $f->temperature->min->getValue(),
                        'unit' => $f->temperature->min->getUnit(),
                        'description' => $f->temperature->min->getDescription()
                    ],
                    'max' => [
                        'value' => $f->temperature->max->getValue(),
                        'unit' => $f->temperature->max->getUnit(),
                        'description' => $f->temperature->max->getDescription()
                    ]
                ],
                'humidity' => [
                    'value' => $f->humidity->getValue(),
                    'unit' => $f->humidity->getUnit(),
                    'description' => $f->humidity->getDescription()
                ],
                'pressure' => [
                    'value' => $f->pressure->getValue(),
                    'unit' => $f->pressure->getUnit(),
                    'description' => $f->pressure->getDescription()
                ],
                'wind' => [
                    'speed' => [
                        'value' => $f->wind->speed->getValue(),
                        'unit' => $f->wind->speed->getUnit(),
                        'description' => $f->wind->speed->getDescription()
                    ],
                    'direction' => [
                        'value' => $f->wind->direction->getValue(),
                        'unit' => $f->wind->direction->getUnit(),
                        'description' => $f->wind->direction->getDescription()
                    ]
                ],
                'clouds' => [
                    'value' => $f->clouds->getValue(),
                    'unit' => $f->clouds->getUnit(),
                    'description' => $f->clouds->getDescription()
                ],
                'precipitation' => [
                    'value' => $f->precipitation->getValue(),
                    'unit' => $f->precipitation->getUnit(),
                    'description' => $f->precipitation->getDescription()
                ],
                'sun' => [
                    'rise' => [
                        'time' => $sunRise->format('Y-m-d H:i:s')
                    ],
                    'set' => [
                        'time' => $sunSet->format('Y-m-d H:i:s')
                    ]
                ],
                'weather' => [
                    'id' => $f->weather->id,
                    'description' => $f->weather->description,
                    'icon' => $f->weather->icon,
                    'iconUrl' => $f->weather->getIconUrl()
                ],
                'lastUpdate' => [
                    'time' => $lastUpdate->format('Y-m-d H:i:s')
                ]
            ];

            $count++;
        }

        $result[$count]['city'] = $cityVars;

        $this->response->setContent(json_encode($result));

        return $this->response;
    }
}
















