<?php

namespace Services;

class FivesimApi extends BaseCommand
{

    public function getPrices($service = null, $country = null)
    {
        $params['service'] = $service;
        $params['country'] = $country;
        return $this->api('getNumbersStatus', $params);
    }

    function setApiEndpoint()
    {
        $this->API_ENDPOINT = getenv('FIVESIM_API_ENDPOINT');
    }

    function setApiKey()
    {
        $this->API_KEY = getenv('FIVESIM_API_KEY');
    }

}