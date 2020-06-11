<?php
require_once(__DIR__ . '/bootstrap.php');
$config_countries = require_once(__DIR__ . '/countries.php');

$api_result = [];
$service_list = [];
$read_api = explode(',', getenv('READ_API'));
// loop all services
foreach ($read_api as $api_key => $api_name) {
    $api_class_name = 'Services\\' . ucfirst(strtolower($api_name)) . 'Api';

    // check if parser for such service exists
    if (class_exists($api_class_name)) {
        // add this service to list
        $service_list[] = getenv($api_name . '_NAME');

        $api_object = new $api_class_name();
        // loop countries
        foreach ($config_countries as $key => $country) {

            // get data for each country
            $data = $api_object->getPrices(getenv('DEFAULT_SERVICE'), $key);

            if ($api_name == 'SMS') {
                $api_result[$key]['country_name'] = $country;
                $api_result[$key]['service'][$api_name] = $data[$key];
            } else {
                $api_result[$key]['service'][$api_name]['wa']['count'] = null;
                if ($data) {
                    foreach ($data as $index => $datum) {

                        if ($index == 'whatsapp_0' || $index == 'whatsapp_1' || $index == 'wa_1' || $index == 'wa_0') {
                            $api_result[$key]['service'][$api_name]['wa']['count'] = $datum;
                        }

                    }
                }
            }

        }
    }
}

$template = $twig->load('table.twig');
echo $template->render([
    'data' => $api_result,
    'service_list' => $service_list
]);
