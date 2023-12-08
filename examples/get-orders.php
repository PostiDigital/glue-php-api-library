<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'config.php';

use Posti\Glue\Api;

try {
    $api = new Api($username, $password, $user_agent, true);
    $api->setDebug(true, "../debug.log");
    $orders = $api->getCatalogOrders($warehouse_id, '2021-08-24');
    echo '<pre>';
    var_dump($orders);
    echo '</pre>';

} catch (\Exception $ex)  {
    echo $ex->getMessage();
}
