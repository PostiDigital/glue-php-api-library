<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'config.php';

use Posti\Glue\Api;

try {
    $api = new Api($username, $password, $contract_number, $user_agent, true);
    $order = $api->getOrder($order_id);
    echo '<pre>';
    var_dump($order);
    echo '</pre>';

} catch (\Exception $ex)  {
    echo $ex->getMessage();
}
