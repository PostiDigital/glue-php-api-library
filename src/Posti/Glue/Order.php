<?php

namespace Posti\Glue;

use Posti\Glue\Order\Address;
use Posti\Glue\Order\Item;
use Posti\Glue\Order\Reference;

class Order
{
    /*
     * @var array
     */

    protected $optional = [
        'routing_service',
        'prefix',
        'use_prefix',
    ];

    /*
     * @var string
     */
    private $id;

    /*
     * @var string
     */
    private $business_id;

    /*
     * @var string
     */
    private $currency;

    /*
     * @var string
     */
    private $total_price;

    /*
     * @var string
     */
    private $total_tax;
    
    /*
     * @var string
     */
    private $prefix;
    
    /*
     * @var bool
     */
    private $use_prefix = true;

    /*
     * @var string
     */
    private $service;

    /*
     * @var string
     */
    private $routing_service;

    /*
     * @var array
     */
    private $additional_services = [];

    /*
     * @var string
     */
    private $order_date;

    /*
     * @var Address
     */
    private $sender;

    /*
     * @var Address
     */
    private $receiver;

    /*
     * @var Address
     */
    private $delivery;
    
    /*
     * @var array
     */
    private $items = [];
    
    /*
     * @var array
     */
    private $references = [];

    private $useBusinessId = true;

    private $deliveryOperator = 'Posti';

    /*
     * @return string
     */

    public function getExternalId() {
        return $this->getPrefix() . $this->getId();
    }

    /*
     * @param string $id
     * @return Order
     */

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /*
     * @return string
     */

    public function getId() {
        return $this->id;
    }

    /*
     * @param bool $use_prefix
     * @return Order
     */

    public function setUsePrefix($use_prefix) {
        $this->use_prefix = $use_prefix;
        return $this;
    }

    /*
     * @return bool
     */

    public function getUsePrefix() {
        return $this->use_prefix;
    }

    /*
     * @param string $prefix
     * @return Order
     */

    public function setPrefix($prefix) {
        $this->prefix = $prefix;
        return $this;
    }

    /*
     * @return string
     */

    public function getPrefix() {
        if ($this->getUsePrefix() !== true) {
            return "";
        }
        if ($this->prefix) {
            return $this->prefix;
        } else {
            return $this->getBusinessId() . '-';
        }
    }

    /*
     * @param string $business_id
     * @return Order
     */

    public function setBusinessId($business_id) {
        $this->business_id = $business_id;
        return $this;
    }

    /*
     * @return string
     */

    public function getBusinessId() {
        return $this->business_id;
    }

    /*
     * @param string $currency
     * @return Order
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
     * @param string $total_price
     * @return Order
     */

    public function setTotalPrice($total_price) {
        $this->total_price = $total_price;
        return $this;
    }

    /*
     * @return string
     */

    public function getTotalPrice() {
        return $this->total_price;
    }

    /*
     * @param string $total_tax
     * @return Order
     */

    public function setTotalTax($total_tax) {
        $this->total_tax = $total_tax;
        return $this;
    }

    /*
     * @return string
     */

    public function getTotalTax() {
        return $this->total_tax;
    }

    /*
     * @param string $service
     * @return Order
     */

    public function setService($service) {
        $this->service = $service;
        return $this;
    }

    /*
     * @return string
     */

    public function getService() {
        return $this->service;
    }

    /*
     * @param string $routing_service
     * @return Order
     */

    public function setRoutingService($routing_service) {
        $this->routing_service = $routing_service;
        return $this;
    }

    /*
     * @return string
     */

    public function getRoutingService() {
        return $this->routing_service;
    }

    /*
     * @param array $additional_services
     * @return Order
     */

    public function setAdditionalServices($additional_services) {
        $this->additional_services = $additional_services;
        return $this;
    }

    /*
     * @return array
     */

    public function getAdditionalServices() {
        return $this->additional_services;
    }

    /*
     * @param string $order_date
     * @return Order
     */

    public function setOrderDate($order_date) {
        $this->order_date = $order_date;
        return $this;
    }

    /*
     * @return string
     */

    public function getOrderDate() {
        return $this->order_date;
    }

    /*
     * @param Address $sender
     * @return Order
     */

    public function setSender(Address $sender) {
        $this->sender = $sender;
        return $this;
    }

    /*
     * @return Address
     */

    public function getSender() {
        return $this->sender;
    }

    /*
     * @param Address $receiver
     * @return Order
     */

    public function setReceiver(Address $receiver) {
        $this->receiver = $receiver;
        if ($this->delivery === null) {
            $this->delivery = $receiver;
        }
        return $this;
    }

    /*
     * @return Address
     */

    public function getReceiver() {
        return $this->receiver;
    }

    /*
     * @param Address $delivery
     * @return Order
     */

    public function setDelivery(Address $delivery) {
        $this->delivery = $delivery;
        return $this;
    }

    /*
     * @return Address
     */

    public function getDelivery() {
        return $this->delivery;
    }

    /**
     * @return Order
     */
    public function setDeliveryOperator($deliveryOperator) {
        $this->deliveryOperator = $deliveryOperator;
        return $this;
    }

    /**
     * @return string Delivery Operator
     */
    public function getDeliveryOperator() {
        return $this->deliveryOperator;
    }
    /*
     * @param Item $item
     * @return Order
     */
    
    public function addItem(Item $item) {
        $this->items[] = $item;
        return $this;
    }
    
    /*
     * @param Reference $item
     * @return Order
     */
    
    public function addReference(Reference $reference) {
        $this->references[] = $reference;
        return $this;
    }

    /*
     * @return array
     */

    public function getItems() {
        return $this->items;
    }

    /**
     * @param bool $useBusinessId
     */
    public function setUseBusinessId(bool $useBusinessId) {
        $this->useBusinessId = $useBusinessId;
    }

    public function getUseBusinessId() {
        return $this->useBusinessId;
    }

    public static function calculate_reference($id) {
        $weights = array(7, 3, 1);
        $sum = 0;

        $base = str_split(strval(($id)));
        $reversed_base = array_reverse($base);
        $reversed_base_length = count($reversed_base);

        for ($i = 0; $i < $reversed_base_length; $i++) {
            $sum += $reversed_base[$i] * $weights[$i % 3];
        }

        $checksum = (10 - $sum % 10) % 10;

        $reference = implode('', $base) . $checksum;

        return $reference;
    }

    public function getData() {

        $this->validate();

        $additional_services = [];

        foreach ($this->additional_services as $_service) {
            $additional_services[] = ["serviceCode" => (string) $_service];
        }
        $order_items = array();

        $item_counter = 1;
        foreach ($this->items as $item) {
            $order_items[] = [
                "externalId" => (string) $item_counter,
                "externalProductId" => $item->getExternalProductId(),
                "productEANCode" => $item->getProductEan(),
                "productUnitOfMeasure" => "KPL",
                "productDescription" => $item->getProductDescription(),
                "externalWarehouseId" => $item->getWarehouseId(),
                "quantity" => $item->getQuantity(),
            ];
            $item_counter++;
        }
        $posti_order_id = $this->getPrefix() . $this->getId();

        $order = array(
            "externalId" => $posti_order_id,
            "orderDate" => date('Y-m-d\TH:i:s.vP', strtotime((string) $this->getOrderDate())),
            "metadata" => [
                "documentType" => "SalesOrder"
            ],
            "references" => [],
            "vendor" => [
                "name" => $this->sender->getName(),
                "streetAddress" => $this->sender->getStreet(),
                "postalCode" => $this->sender->getPostcode(),
                "postOffice" => $this->sender->getCity(),
                "country" => $this->sender->getCountry(),
                "email" => $this->sender->getEmail()
            ],
            "sender" => [
                "name" => $this->sender->getName(),
                "streetAddress" => $this->sender->getStreet(),
                "postalCode" => $this->sender->getPostcode(),
                "postOffice" => $this->sender->getCity(),
                "country" => $this->sender->getCountry(),
                "email" => $this->sender->getEmail()
            ],
            "client" => [
                "externalId" => $this->getPrefix() . $this->receiver->getId(),
                "name" => $this->receiver->getName(),
                "streetAddress" => $this->receiver->getStreet(),
                "postalCode" => $this->receiver->getPostcode(),
                "postOffice" => $this->receiver->getCity(),
                "country" => $this->receiver->getCountry(),
                "telephone" => $this->receiver->getTelephone(),
                "email" => $this->receiver->getEmail(),
            ],
            "recipient" => [
                "externalId" => $this->getPrefix() . $this->receiver->getId(),
                "name" => $this->receiver->getName(),
                "streetAddress" => $this->receiver->getStreet(),
                "postalCode" => $this->receiver->getPostcode(),
                "postOffice" => $this->receiver->getCity(),
                "country" => $this->receiver->getCountry(),
                "telephone" => $this->receiver->getTelephone(),
                "email" => $this->receiver->getEmail(),
            ],
            "deliveryAddress" => [
                "externalId" => $this->getPrefix() . $this->delivery->getId(),
                "name" => $this->delivery->getName(),
                "streetAddress" => $this->delivery->getStreet(),
                "postalCode" => $this->delivery->getPostcode(),
                "postOffice" => $this->delivery->getCity(),
                "country" => $this->delivery->getCountry(),
                "telephone" => $this->delivery->getTelephone(),
                "email" => $this->delivery->getEmail(),
            ],
            "currency" => $this->getCurrency(),
            "serviceCode" => $this->getService(),
            "routingServiceCode" => $this->getRoutingService(),
            "totalPrice" => $this->getTotalPrice(),
            "totalTax" => $this->getTotalTax(),
            "totalWholeSalePrice" => $this->getTotalPrice() + $this->getTotalTax(),
            "deliveryOperator" => $this->getDeliveryOperator(),
            "rows" => $order_items
        );
        /*
          if ($pickup_point) {
          $address = $this->pickupPointData($pickup_point, $_order, $business_id);
          if ($address) {
          $order['deliveryAddress'] = $address;
          }
          } */

        if ($this->getUseBusinessId()) {
            $order["clientId"] = (string) $this->getBusinessId();
        }

        if (!empty($additional_services)) {
            $order['additionalServices'] = $additional_services;
        }
        
        //add references
        foreach ($this->references as $reference) {
            $order["references"][] = $reference->toArray();
        }

        return $order;
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
        if (empty($this->items)) {
             $errors[] = 'Order items are missing. Add them with addItem($item).';
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
    
    /*
     * @param array $data
     * @return Order
     */
    //TO DO: make clever way of filling Object to array
    /*
    public function fillData($data) {
        if (!is_array($data)) {
            return false;
        }
        $this->setExternalId($data['externalId'] ?? null);
        $this->setCatalogType($data['catalogType'] ?? null);
        $this->setCatalogName($data['catalogName'] ?? null);
        $this->setSupplierId($data['supplierId'] ?? null);
        $this->setRetailerId($data['retailerId'] ?? null);
        $this->setBackOrderAllowed($data['backOrderAllowed'] ?? null);
        $this->setPriority($data['priority'] ?? null);
        $this->setRouteWeight($data['routeWeight'] ?? null);
        $this->setPublic($data['public'] ?? null);
        return $this;
    }
    */
}
