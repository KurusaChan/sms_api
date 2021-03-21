<?php
require_once(__DIR__ . '/bootstrap.php');
$configCountries = require_once(__DIR__ . '/countries.php');

$apiResult = [];
$serviceList = [];
$readApi = explode(',', getenv('READ_API'));
// loop all services
foreach ($readApi as $apiKey => $apiName) {
    $apiClassName = 'Services\\' . ucfirst(strtolower($apiName)) . 'Api';

    // check if parser for such service exists
    if (class_exists($apiClassName)) {
        // add this service to list
        $serviceList[] = getenv($apiName . '_NAME');

        $apiObject = new $apiClassName();
        // loop countries
        foreach ($configCountries as $key => $country) {

            // get data for each country
            $data = $apiObject->getPrices(getenv('DEFAULT_SERVICE'), $key);

            if ($apiName == 'SMS') {
                $apiResult[$key]['country_name'] = $country;
                $apiResult[$key]['service'][$apiName] = $data[$key];
            } else {
                $apiResult[$key]['service'][$apiName]['wa']['count'] = null;
                if ($data) {
                    foreach ($data as $index => $datum) {

                        if ($index == 'whatsapp_0' || $index == 'whatsapp_1' || $index == 'wa_1' || $index == 'wa_0') {
                            $apiResult[$key]['service'][$apiName]['wa']['count'] = $datum;
                        }

                    }
                }
            }

        }
    }
}

$template = $twig->load('table.twig');
echo $template->render([
    'data'        => $apiResult,
    'serviceList' => $serviceList
]);
