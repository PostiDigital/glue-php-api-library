<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'config.php';

use Posti\Glue\Api;

try {
    $api = new Api($username, $password, $business_id, $contract_number, true);
    $catalogs = $api->getCatalogs();
    foreach ($catalogs as $catalog) {
        echo $catalog->getExternalId() . ', ' . $catalog->getCatalogName();
        break;
    }

} catch (\Exception $ex)  {
    echo $ex->getMessage();
}
