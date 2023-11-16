<?php

namespace Posti\Glue;

use Posti\Glue\Fields;

class StockBalance
{
    /*
     * @var string
     */
    private $retailer_id;
    /*
     * @var string
     */
    private $product_external_id;
    /*
     * @var string
     */
    private $catalog_external_id;
    /*
     * @var float
     */
    private $wholesale_price;
    /*
     * @var float
     */
    private $currency;
    /*
     * @var float
     */
    private $quantity = null;
    /*
     * @var float
     */
    private $incoming = null;

    /**
     * @return float|null
     */
    public function getIncoming()
    {
        return $this->incoming;
    }

    /**
     * @param float|null $incoming
     */
    public function setIncoming($incoming)
    {
        $this->incoming = $incoming;
    }

    /*
     * @param string $external_id
     * @return StockBalance
     */
    public function setCatalogExternalId($external_id) {
        $this->catalog_external_id = $external_id;
        return $this;
    }
    
    /*
     * @return string
     */
    public function getCatalogExternalId() {
        return $this->catalog_external_id;
    }

    /*
     * @param string $external_id
     * @return StockBalance
     */
    public function setProductExternalId($external_id) {
        $this->product_external_id = $external_id;
        return $this;
    }
    
    /*
     * @return string
     */
    public function getProductExternalId() {
        return $this->product_external_id;
    }
    
    /*
     * @param string $retailer_id
     * @return StockBalance
     */
    public function setRetailerId($retailer_id) {
        $this->retailer_id = $retailer_id;
        return $this;
    }

    /*
     * @return string
     */
    public function getRetailerId() {
        return $this->retailer_id;
    }

    /*
     * @param string $currency
     * @return StockBalance
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /*
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /*
     * @param float $wholesale_price
     * @return StockBalance
     */
    public function setWholesalePrice($wholesale_price) {
        $this->wholesale_price = $wholesale_price;
        return $this;
    }

    /*
     * @return float
     */
    public function getWholesalePrice() {
        return $this->wholesale_price;
    }
    
    /*
     * @param float $quantity
     * @return StockBalance
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    /*
     * @return float
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /*
     * @param array $data
     * @return StockBalance
     */
    public function fillData($data) {
        $this->setRetailerId($data['retailerId'] ?? null);
        $this->setCatalogExternalId($data['catalogExternalId'] ?? null);
        $this->setProductExternalId($data['productExternalId'] ?? null);
        $this->setCurrency($data['currency'] ?? null);
        $this->setWholesalePrice($data['wholesalePrice'] ?? null);
        $this->setQuantity($data['quantity'] ?? null);
        $this->setIncoming($data['incoming'] ?? null);

        return $this;
    }

    /*
     * @return mixed
     */
    public function getData() {
        $result = array();
        Fields::addOptField($result, 'retailerId', $this->getRetailerId());
        Fields::addOptField($result, 'catalogExternalId', $this->getCatalogExternalId());
        Fields::addOptField($result, 'productExternalId', $this->getProductExternalId());
        Fields::addOptField($result, 'currency', $this->getCurrency());
        Fields::addOptField($result, 'wholesalePrice', $this->getWholesalePrice());
        Fields::addOptField($result, 'quantity', $this->getQuantity());
        Fields::addOptField($result, 'incoming', $this->getIncoming());

        return $result;
    }

}
