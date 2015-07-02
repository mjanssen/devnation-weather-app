<?php
/**
 * User: marnixjanssen
 * Date: 6/8/15
 */

namespace Devnation\App\Library\Weather;

use \Cmfcmf\OpenWeatherMap;

class Weather {

    protected $config;
    protected $openWeatherMap;

    public function __construct()
    {
        $this->config = include APP_PATH . "/app/config/weather.php";
        $this->openWeatherMap = new OpenWeatherMap();
    }

    public function getWeatherForCity($city, $dayAmount = 10)
    {
        return $this->openWeatherMap->getWeatherForecast($city, $this->config->api->unit, $this->config->api->lang, '', $dayAmount);
    }

    public function getCityVars($city)
    {
        return $this->openWeatherMap->getRawWeatherData($city, $this->config->api->unit, $this->config->api->lang, '', 'json');
    }

    public function getCitiesInfo($city_ids)
    {
        return $this->openWeatherMap->getRawWeatherDataForCities($city_ids, $this->config->api->unit, $this->config->api->lang, '', 'json');
    }
}