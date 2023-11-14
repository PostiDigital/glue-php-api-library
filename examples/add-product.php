<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'config.php';

use Posti\Glue\Api;
use Posti\Glue\Product;

try {
    $product = new Product();
    $product->setWarehouse($warehouse_id);
    $product->setBusinessId($business_id);
    //$product->setSupplierId("");
    $product->setDistributor($distributor_id);
    
    $product->setName("Api test product");
    $product->setDescription("Description of product");
    
    $product->setIsDangerous(false);
    $product->setIsFragile(true);
    $product->setIsOversized(false);
    
    $product->setCurrency("EUR");
    $product->setRecommendedRetailPrice(10.6);
    $product->setWholesalePrice(10.6);
    
    $product->setExternalId("TEST-0123456789");
    
    $product->setHeight(0.3); //m
    $product->setLength(0.1); //m
    $product->setWidth(0.2); //m
    $product->setWeight(0.4); //kg
    
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
    $result = $api->addProduct($product);
    if ($result !== false) {
        echo 'Product added/updated';
    }

} catch (\Exception $ex)  {
    echo $ex->getMessage();
}
