<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'config.php';

use Posti\Glue\Api;
use Posti\Glue\InventoryItem;
use Posti\Glue\StockBalance;

try {
    $product = new InventoryItem();
    $product->setDistributor($distributor_id);
    
    $product->setName("Api test product");
    $product->setDescription("Description of product");
    
    $product->setIsDangerous(false);
    $product->setIsFragile(true);
    $product->setIsOversized(false);
    
    $product->setCurrency("EUR");
    $product->setRecommendedRetailPrice(10.6);    
    $product->setExternalId("TEST-0123456789");
    
    $product->setHeight(0.3); //m
    $product->setLength(0.1); //m
    $product->setWidth(0.2); //m
    $product->setWeight(0.4); //kg
    
    $balance = new StockBalance();
    $balance->setCatalogExternalId($warehouse_id);
    $balance->setRetailerId($retailer_id);
    $balance->setWholesalePrice(10.6);
    $balance->setCurrency("EUR");
    $product->addBalance($balance);
    
    $specification = array([
        "type"=> "Options",
        "properties"=> [
            [
                "name" => "color",
                "value"=> "black",
                "specifier" => "",
                "description" => ""
            ]
        ]
    ]);
    $product->setSpecifications($specification);
    
    $api = new Api($username, $password, $user_agent, true);
    $api->setDebug(true, "../debug.log");
    $result = $api->addInventoryItems($product);
    if ($result !== false) {
        echo 'Product added/updated';
    }

} catch (\Exception $ex)  {
    echo $ex->getMessage();
}
