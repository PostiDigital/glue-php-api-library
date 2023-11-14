<?php

namespace Posti\Glue;

use Posti\Glue\Attachment;
use Posti\Glue\Image;

class Product
{
    /*
     * @var array
     */
    
    protected $optional = [
//        'warehouse',
        'external_id',
        'supplier_id',
        'wholesale_price',
        'recommended_retail_price',
        'quantity',
        'specifications',
        'attachments',
        'images',
        'incoming',
        'retailer_id'
    ];
    
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

    private $retailer_id;

    /*
     * @var string
     */
    private $warehouse;

    /*
     * @var string
     */
    private $distributor;

    /*
     * @var string
     */
    private $ean;

    /*
     * @var string
     */
    private $currency;

    /*
     * @var float
     */
    private $recommended_retail_price;

    /*
     * @var float
     */
    private $wholesale_price;
    
    /*
     * @var float
     */
    private $quantity;

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
    private $attachments = [];
    
    /*
     * @var array
     */
    private $images = [];
    
    /*
     * @var bool
     */
    private $send_balances = true;

    /**
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
     * @return Product
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
     * @return Product
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
     * @param string $retailer_id
     * @return Product
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
     * @param string $warehouse
     * @return Product
     */

    public function setWarehouse($warehouse) {
        $this->warehouse = $warehouse;
        return $this;
    }

    /*
     * @return string
     */

    public function getWarehouse() {
        return $this->warehouse;
    }

    /*
     * @param string $distributor
     * @return Product
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
     * @param string $ean
     * @return Product
     */

    public function setEan($ean) {
        $this->ean = $ean;
        return $this;
    }

    /*
     * @return string
     */

    public function getEan() {
        return $this->ean;
    }

    /*
     * @param string $currency
     * @return Product
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
     * @param float $price
     * @return Product
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
     * @param float $wholesale_price
     * @return Product
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
     * @return Product
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
     * @param string $name
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
     */

    public function addAttachment(Attachment $attachment) {
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
     * @return Product
     */

    public function addImage(Image $image) {
        $this->images[] = $image;
        return $this;
    }

    /*
     * @return mixed
     */

    public function getImages() {
        return $this->images;
    }

    /*
     * @param bool $send_balances
     * @return Product
     */

    public function setSendBalances($send_balances) {
        $this->send_balances = $send_balances;
        return $this;
    }

    /*
     * @return bool
     */

    public function getSendBalances() {
        return $this->send_balances;
    }

    /*
     * @param array $data
     * @return Product
     */

    public function fillData($data) {
        if (is_array($data) && isset($data['balances'])) {
            $data['balance'] = $data['balances'][0];
        }
        if (!is_array($data) || !isset($data['product']) || !isset($data['balance'])) {
            return false;
        }
        
        $this->setExternalId($data['product']['externalId'] ?? null);
        $this->setEan($data['product']['eanCode'] ?? null);
        $this->setWarehouse($data['balance']['catalogExternalId'] ?? null);
        $this->setRetailerId($data['product']['supplierId'] ?? null);
        $this->setDistributor($data['product']['distributor'] ?? null);

        $this->setName($data['product']['descriptions']['en']['name'] ?? null);
        $this->setDescription($data['product']['descriptions']['en']['description'] ?? null);

        $this->setIsDangerous($data['product']['isDangerousGoods'] ?? false);
        $this->setIsFragile($data['product']['isFragile'] ?? false);
        $this->setIsOversized($data['product']['isOversized'] ?? false);

        $this->setCurrency($data['balance']['currency'] ?? null);
        $this->setRecommendedRetailPrice($data['product']['recommendedRetailPrice'] ?? null);
        $this->setWholesalePrice($data['balance']['wholesalePrice'] ?? null);
        $this->setQuantity($data['balance']['quantity'] ?? null);
        $this->setIncoming($data['balance']['incoming'] ?? null);

        $this->setHeight($data['product']['measurements']['height'] ?? null);
        $this->setLength($data['product']['measurements']['length'] ?? null);
        $this->setWidth($data['product']['measurements']['width'] ?? null);
        $this->setWeight($data['product']['measurements']['weight'] ?? null);
        
        $this->setSpecifications($data['product']['descriptions']['en']['specifications'] ?? null);
        
        return $this;
    }

    /*
     * @return mixed
     */

    public function getData() {
        $this->validate();
        $product = array(
            'externalId' => $this->external_id,
            'descriptions' => array(
                'en' => array(
                    'name' => $this->name,
                    'description' => $this->description,
                    'attachments' => []
                )
            ),
            'eanCode' => $this->ean,
            "unitOfMeasure" => "KPL",
            "status" => "ACTIVE",
            "recommendedRetailPrice" => $this->recommended_retail_price,
            "currency" => $this->currency,
            "distributor" => $this->distributor,
            "isFragile" => $this->is_fragile,
            "isDangerousGoods" => $this->is_dangerous,
            "isOversized" => $this->is_oversized,
            "images" => []
        );
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

        $product['measurements'] = array(
            "weight" => $this->weight,
            "length" => $this->length,
            "width" => $this->width,
            "height" => $this->height,
        );
        
        if ($this->specifications) {
            $product['descriptions']['en']['specifications'] = $this->specifications;
        }

        $balances = [];
	$balance = [
                "retailerId" => $this->retailer_id,
                "productExternalId" => $this->external_id,
                "catalogExternalId" => $this->warehouse,
                //"quantity" => 0.0,
                "wholesalePrice" => $this->wholesale_price,
                "currency" => $this->currency
	];

	$balances[] = $balance;

        if ($this->send_balances === true) {
            return array('product' => $product, 'balances' => $balances);
        } else {
            return array('product' => $product);
        }
    }

    /*
     * @return mixed
     */

    private function validate() {
        $errors = [];
        $vars = get_object_vars($this);
        foreach ($vars as $var => $value) {
            if (in_array(trim($var, '$'), $this->optional)) {
                continue;
            }
            if ($value === null) {
                $errors[] = 'Variable ' . $var . ' is missing. Set it with set' . $this->getMethodName($var) . '($val).';
            }
        }
        if (!empty($errors)) {
            throw new \Exception(implode("<br/>", $errors));
        }
        return true;
    }

    /*
     * @param string $var
     * @return string
     */

    private function getMethodName($var) {
        $name = '';
        $parts = explode('_', trim($var, '$'));
        foreach ($parts as $part) {
            $name .= ucfirst($part);
        }
        return $name;
    }

}
