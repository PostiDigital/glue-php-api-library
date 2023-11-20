<?php

namespace Posti\Glue;

use Posti\Glue\Attachment;
use Posti\Glue\Image;
use Posti\Glue\StockBalance;
use Posti\Glue\Fields;

class InventoryItem
{
    /*
     * @var string
     */
    private $external_id;
    
    /*
     * @var string
     */
    private $supplier_id;

    /*
     * @var string
     */
    private $distributor;

    /*
     * @var string
     */
    private $ean_code;

    /*
     * @var string
     */
    private $currency;

    /*
     * @var string
     */
    private $unit_of_measure = 'KPL';

    /*
     * @var float
     */
    private $recommended_retail_price;

    /*
     * @var string
     */
    private $name;

    /*
     * @var string
     */
    private $description;

    /*
     * @var float
     */
    private $weight;

    /*
     * @var float
     */
    private $length;

    /*
     * @var float
     */
    private $width;

    /*
     * @var float
     */
    private $height;

    /*
     * @var bool
     */
    private $is_fragile = false;

    /*
     * @var bool
     */
    private $is_dangerous = false;

    /*
     * @var bool
     */
    private $is_oversized = false;
    
    /*
     * @var mixed
     */
    private $specifications;
    
    /*
     * @var array
     */
    private $attachments = null;
    
    /*
     * @var array
     */
    private $images = null;
    
    /*
     * @var array
     */
    private $balances = null;

    /*
     * @param string $external_id
     * @return InventoryItem
     */

    public function setExternalId($external_id) {
        $this->external_id = $external_id;
        return $this;
    }
    
    /*
     * @return string
     */

    public function getExternalId() {
        return $this->external_id;
    }

    /*
     * @param string $supplier_id
     * @return InventoryItem
     */

    public function setSupplierId($supplier_id) {
        $this->supplier_id = $supplier_id;
        return $this;
    }
    
    /*
     * @return string
     */

    public function getSupplierId() {
        return $this->supplier_id;
    }
    
    /*
     * @param string $distributor
     * @return InventoryItem
     */

    public function setDistributor($distributor) {
        $this->distributor = $distributor;
        return $this;
    }

    /*
     * @return string
     */

    public function getDistributor() {
        return $this->distributor;
    }

    /*
     * @param string $ean_code
     * @return InventoryItem
     */

    public function setEanCode($ean_code) {
        $this->ean_code = $ean_code;
        return $this;
    }

    /*
     * @return string
     */

    public function getEanCode() {
        return $this->ean_code;
    }

    /*
     * @param string $currency
     * @return InventoryItem
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
     * @param string $currency
     * @return InventoryItem
     */
    
    public function setUnitOfMeasure($unit_of_measure) {
        $this->unit_of_measure = $unit_of_measure;
        return $this;
    }
    
    /*
     * @return string
     */
    public function getUnitOfMeasure() {
        return $this->unit_of_measure;
    }
    
    /*
     * @param float $price
     * @return InventoryItem
     */

    public function setRecommendedRetailPrice($recommended_retail_price) {
        $this->recommended_retail_price = $recommended_retail_price;
        return $this;
    }

    /*
     * @return float
     */

    public function getRecommendedRetailPrice() {
        return $this->recommended_retail_price;
    }

    /*
     * @param string $name
     * @return InventoryItem
     */

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /*
     * @return string
     */

    public function getName() {
        return $this->name;
    }

    /*
     * @param string $description
     * @return InventoryItem
     */

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /*
     * @return string
     */

    public function getDescription() {
        return $this->description;
    }

    /*
     * @param float $weight
     * @return InventoryItem
     */

    public function setWeight($weight) {
        $this->weight = $weight;
        return $this;
    }

    /*
     * @return float
     */

    public function getWeight() {
        return $this->weight;
    }

    /*
     * @param float $length
     * @return InventoryItem
     */

    public function setLength($length) {
        $this->length = $length;
        return $this;
    }

    /*
     * @return float
     */

    public function getLength() {
        return $this->length;
    }

    /*
     * @param float $width
     * @return InventoryItem
     */

    public function setWidth($width) {
        $this->width = $width;
        return $this;
    }

    /*
     * @return float
     */

    public function getWidth() {
        return $this->width;
    }

    /*
     * @param float $height
     * @return InventoryItem
     */

    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }

    /*
     * @return float
     */

    public function getHeight() {
        return $this->height;
    }

    /*
     * @param bool $is_fragile
     * @return InventoryItem
     */

    public function setIsFragile($is_fragile) {
        $this->is_fragile = $is_fragile;
        return $this;
    }

    /*
     * @return bool
     */

    public function getIsFragile() {
        return $this->is_fragile;
    }

    /*
     * @param bool $is_dangerous
     * @return InventoryItem
     */

    public function setIsDangerous($is_dangerous) {
        $this->is_dangerous = $is_dangerous;
        return $this;
    }

    /*
     * @return bool
     */

    public function getIsDangerous() {
        return $this->is_dangerous;
    }

    /*
     * @param bool $is_oversized
     * @return InventoryItem
     */

    public function setIsOversized($is_oversized) {
        $this->is_oversized = $is_oversized;
        return $this;
    }

    /*
     * @return bool
     */

    public function getIsOversized() {
        return $this->is_oversized;
    }
    
    /*
     * @param mixed $specifications
     * @return InventoryItem
     */

    public function setSpecifications($specifications) {
        $this->specifications = $specifications;
        return $this;
    }

    /*
     * @return mixed
     */

    public function getSpecifications() {
        return $this->specifications;
    }
    
    /*
     * @param Attachment $attachments
     * @return InventoryItem
     */

    public function addAttachment(Attachment $attachment) {
        if (!isset($this->attachments)) {
            $this->attachments = array();
        }
        
        $this->attachments[] = $attachment;
        return $this;
    }

    /*
     * @return mixed
     */

    public function getAttachments() {
        return $this->attachments;
    }
    
    /*
     * @param Image $image
     * @return InventoryItem
     */

    public function addImage(Image $image) {
        if (!isset($this->images)) {
            $this->images = array();
        }

        $this->images[] = $image;
        return $this;
    }

    /*
     * @return mixed
     */
    public function getImages() {
        return $this->images;
    }

    public function addBalance(StockBalance $balance) {
        if (!isset($this->balances)) {
            $this->balances = array();
        }

        $this->balances[] = $balance;
        return $this;
    }
    
    /*
     * @return mixed
     */
    public function setBalances($balances) {
        $this->balances = $balances;
        return $this;
    }

    /*
     * @return mixed
     */
    public function getBalances() {
        return $this->balances;
    }

    /*
     * @param array $data
     * @return InventoryItem
     */
    public function fillData($data) {
        if (!is_array($data) || !isset($data['product'])) {
            return false;
        }
        
        $this->setExternalId($data['product']['externalId'] ?? null);
        $this->setEanCode($data['product']['eanCode'] ?? null);
        $this->setDistributor($data['product']['distributor'] ?? null);

        $this->setName($data['product']['descriptions']['en']['name'] ?? null);
        $this->setDescription($data['product']['descriptions']['en']['description'] ?? null);

        $this->setIsDangerous($data['product']['isDangerousGoods'] ?? false);
        $this->setIsFragile($data['product']['isFragile'] ?? false);
        $this->setIsOversized($data['product']['isOversized'] ?? false);

        $this->setCurrency($data['product']['currency'] ?? null);
        $this->setRecommendedRetailPrice($data['product']['recommendedRetailPrice'] ?? null);
        $this->setHeight($data['product']['measurements']['height'] ?? null);
        $this->setLength($data['product']['measurements']['length'] ?? null);
        $this->setWidth($data['product']['measurements']['width'] ?? null);
        $this->setWeight($data['product']['measurements']['weight'] ?? null);
        $this->setSpecifications($data['product']['descriptions']['en']['specifications'] ?? null);

        if (isset($data['balances'])) {
            foreach ($data['balances'] as $b) {
                $balance = new StockBalance();
                $balance->fillData($b);

                $this->addBalance($balance);
            }
        }
        else {
            $this->setBalances(null);
        }
        
        return $this;
    }

    /*
     * @return mixed
     */
    public function getData() {
        $product = array(
            'externalId' => $this->external_id,
            'descriptions' => array(
                'en' => array(
                    'name' => $this->name,
                    'description' => $this->description,
                    'attachments' => []
                )
            ),
            "unitOfMeasure" => $this->unit_of_measure,
            "images" => []
        );
        
        Fields::addOptField($product, 'recommendedRetailPrice', $this->recommended_retail_price);
        Fields::addOptField($product, 'currency', $this->currency);
        Fields::addOptField($product, 'eanCode', $this->ean_code);
        Fields::addOptField($product, 'distributor', $this->distributor);
        Fields::addOptField($product, 'isFragile', $this->is_fragile);
        Fields::addOptField($product, 'isDangerousGoods', $this->is_dangerous);
        Fields::addOptField($product, 'isOversized', $this->is_oversized);
        
        if ($this->supplier_id !== null) {
            $product["supplierId"] = $this->supplier_id;
        }
        
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $product['descriptions']['en']['attachments'][] = $attachment->getData();
            }
        }
        
        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                $product['images'][] = $image->getData();
            }
        }

        if (isset($this->weight)
            || isset($this->length)
            || isset($this->width)
            || isset($this->height)) {

            $measurements = array();
            Fields::addOptField($measurements, 'weight', $this->weight);
            Fields::addOptField($measurements, 'length', $this->length);
            Fields::addOptField($measurements, 'width', $this->width);
            Fields::addOptField($measurements, 'height', $this->height);
            $product['measurements'] = $measurements;
        }
        
        if ($this->specifications) {
            $product['descriptions']['en']['specifications'] = $this->specifications;
        }
        
        $result = array();
        $result['product'] = $product;

        if (isset($this->balances)) {
            $balances = array();
            foreach ($this->balances as $b) {
                $balances[] = $b->getData();
            }

            $result['balances'] = $balances;
        }

        return $result;
    }
}
