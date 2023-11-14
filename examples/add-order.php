<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'config.php';

use Posti\Glue\Api;
use Posti\Glue\Order;
use Posti\Glue\Order\Address;
use Posti\Glue\Order\Item;

try {
    $order = new Order();
    
    $order->setId('123');
    $order->setOrderDate('2021-01-01 08:00:00');
    $order->setCurrency('EUR');
    $order->setTotalPrice(20.10);
    $order->setTotalTax(5.30);
    $order->setService('12345');
    
    $sender = new Address();
    $sender->setName('Test sender');
    $sender->setStreet('Test street 1');
    $sender->setPostcode('12345');
    $sender->setCity('City');
    $sender->setCountry('LT');
    $sender->setTelephone('+37060000000');
    $sender->setEmail('info@mijora.lt');
    
    $order->setSender($sender);
    
    $receiver = new Address();
    $receiver->setId('12345');
    $receiver->setName('Test receiver');
    $receiver->setStreet('Test street 1');
    $receiver->setPostcode('12345');
    $receiver->setCity('City');
    $receiver->setCountry('LT');
    $receiver->setTelephone('+37060000000');
    $receiver->setEmail('info@mijora.lt');
    
    $order->setReceiver($receiver);
    
    $item = new Item();    
    $item->setExternalProductId($product_id);
    $item->setProductEan('product_ean');
    $item->setProductDescription('Test product');
    $item->setWarehouseId($warehouse_id);
    $item->setQuantity(3);
    
    $order->addItem($item);
    
    
    $api = new Api($username, $password, $contract_number, $user_agent, true);
    $api->setDebug(true, "../debug.log");
    $result = $api->addOrder($order);
    if ($result !== false) {
        echo 'Order added: ' . $result;
    }

} catch (\Exception $ex)  {
    echo $ex->getMessage();
}
