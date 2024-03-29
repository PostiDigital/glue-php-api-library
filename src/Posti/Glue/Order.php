<?php

namespace Posti\Glue;

use Posti\Glue\Order\Address;
use Posti\Glue\Order\Item;
use Posti\Glue\Order\Reference;

class Order
{
    /*
     * @var string
     */
    private $external_id;

    /*
     * @var string
     */
    private $status;
    
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
    private $service;

    /*
     * @var string
     */
    private $routing_service;

    /*
     * @var int
     */
    private $pickup_point_id;

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

    private $deliveryOperator;

    /*
     * @return string
     */

    public function setExternalId($external_id) {
        $this->external_id = $external_id;
        return $this;
    }
    
    public function getExternalId() {
        return $this->external_id;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
    
    public function getStatus() {
        return $this->status;
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
     * @param string $pickup_point_id
     * @return Order
     */

    public function setPickupPointId($pickup_point_id) {
        $this->pickup_point_id = $pickup_point_id;
        return $this;
    }

    /*
     * @return string
     */

    public function getPickupPointId() {
        return $this->pickup_point_id;
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

    public function getData() {
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

        $order = array(
            "externalId" => $this->external_id,
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
                "externalId" => $this->receiver->getId(),
                "name" => $this->receiver->getName(),
                "streetAddress" => $this->receiver->getStreet(),
                "postalCode" => $this->receiver->getPostcode(),
                "postOffice" => $this->receiver->getCity(),
                "country" => $this->receiver->getCountry(),
                "telephone" => $this->receiver->getTelephone(),
                "email" => $this->receiver->getEmail(),
            ],
            "recipient" => [
                "externalId" => $this->receiver->getId(),
                "name" => $this->receiver->getName(),
                "streetAddress" => $this->receiver->getStreet(),
                "postalCode" => $this->receiver->getPostcode(),
                "postOffice" => $this->receiver->getCity(),
                "country" => $this->receiver->getCountry(),
                "telephone" => $this->receiver->getTelephone(),
                "email" => $this->receiver->getEmail(),
            ],
            "deliveryAddress" => [
                "externalId" => $this->delivery->getId(),
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
            "pickupPointId" => $this->getPickupPointId(),
            "totalPrice" => $this->getTotalPrice(),
            "totalTax" => $this->getTotalTax(),
            "totalWholeSalePrice" => round($this->getTotalPrice() + $this->getTotalTax(), 2),
            "rows" => $order_items
        );
        
        if (!empty($this->getDeliveryOperator())) {
            $order['deliveryOperator'] = $this->getDeliveryOperator();
        }

        $additional_services = [];
        foreach ($this->additional_services as $_service) {
            $additional_services[] = ["serviceCode" => (string) $_service];
        }
        if (!empty($additional_services)) {
            $order['additionalServices'] = $additional_services;
        }

        if (!empty($this->status)) {
            $order['status'] = array(
                'value' => $this->status
            );
        }

        //add references
        foreach ($this->references as $reference) {
            $order["references"][] = $reference->toArray();
        }

        return $order;
    }
}

