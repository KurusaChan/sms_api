<?php

namespace Services;

class GetsmsApi extends BaseCommand
{

    public function getPrices($service = null, $country = null)
    {
        $params['service'] = $service;
        $params['country'] = $country;
        return $this->api('getNumbersStatus', $params);
    }

    function setApiEndpoint()
    {
        $this->API_ENDPOINT = getenv('GETSMS_API_ENDPOINT');
    }

    function setApiKey()
    {
        $this->API_KEY = getenv('GETSMS_API_KEY');
    }

}