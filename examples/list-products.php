<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'config.php';

use Posti\Glue\Api;

try {
    $api = new Api($username, $password, $business_id, $contract_number, true);
    $api->setDebug(true, "../debug.log");
    $products = $api->getProductsByCatalog($warehouse_id, $business_id);
    echo '<pre>';
    print_r($products);
    echo '</pre>';

} catch (\Exception $ex)  {
    echo $ex->getMessage();
}
