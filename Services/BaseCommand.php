<?php

namespace Services;

abstract class BaseCommand
{

    protected $API_ENDPOINT;
    protected $API_KEY;

    protected $curl;
    protected $result;
    protected $api_result;
    protected $config_countries;

    public function __construct()
    {
        $this->curl = curl_init();
        $this->config_countries = require(__DIR__ . '/../countries.php');

        $this->setApiEndpoint();
        $this->setApiKey();
    }

    public function api(string $method, array $params)
    {
        $url = $this->API_ENDPOINT . '?';

        $params['api_key'] = $this->API_KEY;
        $params['action'] = $method;

        return $this->do($url, $params);
    }


    private function do(string $url, array $params = [])
    {
        $url .= http_build_query($params);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $this->result = json_decode(curl_exec($this->curl), TRUE);
        return $this->result;
    }

    public function __destruct()
    {
        $this->curl = curl_close($this->curl);
    }

    abstract function getPrices($service = null, $country = null);

    abstract function setApiEndpoint();
    abstract function setApiKey();

}