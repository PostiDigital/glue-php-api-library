<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'config.php';

use Posti\Glue\Api;

try {
    $api = new Api($username, $password, $contract_number, $user_agent, true);
    $api->setDebug(true, "../debug.log");
    //log to function
    //$api->setDebug(true, static function($message, $type) { var_dump($type . ' ' . $message ); });
    $balances = $api->getBalances();
    echo '<pre>';
    var_dump($balances);
    echo '</pre>';

} catch (\Exception $ex)  {
    echo $ex->getMessage();
}
