<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'config.php';

use Posti\Glue\Api;

try {
    $api = new Api($username, $password, $user_agent, true);
    $product = $api->getProduct($product_id);
    echo '<pre>';
    var_dump($product);
    echo '</pre>';

} catch (\Exception $ex)  {
    echo $ex->getMessage();
}
