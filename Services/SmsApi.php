<?php

namespace Services;

class SmsApi extends BaseCommand
{

    public function getPrices($service = null, $country = null)
    {
        $params['service'] = $service;
        $params['country'] = $country;
        return $this->api('getPrices', $params);
    }

    function setApiEndpoint()
    {
        $this->API_ENDPOINT = getenv('SMS_API_ENDPOINT');
    }

    function setApiKey()
    {
        $this->API_KEY = getenv('SMS_API_KEY');
    }

}