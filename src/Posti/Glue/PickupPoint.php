<?php

namespace Posti\Glue;

use Posti\Glue\Fields;

class PickupPoint
{
    /*
     * @var string
     */
    private $external_id;
    /*
     * @var string
     */
    private $type;
    /*
     * @var string
     */
    private $service_provider;
    /*
     * @var string
     */
    private $name;
    /*
     * @var string
     */
    private $street_address;
    /*
     * @var string
     */
    private $postal_code;
    /*
     * @var string
     */
    private $post_office;
    /*
     * @var string
     */
    private $country;
    /*
     * @var float
     */
    private $latitude;
    /*
     * @var float
     */
    private $longitude;
    
    /**
     * @return mixed
     */
    public function getExternalId() {
        return $this->external_id;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getServiceProvider() {
        return $this->service_provider;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getStreetAddress() {
        return $this->street_address;
    }

    /**
     * @return mixed
     */
    public function getPostalCode() {
        return $this->postal_code;
    }

    /**
     * @return mixed
     */
    public function getPostOffice() {
        return $this->post_office;
    }

    /**
     * @return mixed
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * @param mixed $external_id
     */
    public function setExternalId($external_id) {
        $this->external_id = $external_id;
    }

    /**
     * @param mixed $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @param mixed $service_provider
     */
    public function setServiceProvider($service_provider) {
        $this->service_provider = $service_provider;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @param mixed $street_address
     */
    public function setStreetAddress($street_address) {
        $this->street_address = $street_address;
    }

    /**
     * @param mixed $postal_code
     */
    public function setPostalCode($postal_code) {
        $this->postal_code = $postal_code;
    }

    /**
     * @param mixed $post_office
     */
    public function setPostOffice($post_office) {
        $this->post_office = $post_office;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    /*
     * @param array $data
     * @return StockBalance
     */
    public function fillData($data) {
        $this->setExternalId($data['externalId'] ?? null);
        $this->setType($data['type'] ?? null);
        $this->setServiceProvider($data['serviceProvider'] ?? null);
        $this->setName($data['name'] ?? null);
        $this->setStreetAddress($data['streetAddress'] ?? null);
        $this->setPostalCode($data['postalCode'] ?? null);
        $this->setPostOffice($data['postOffice'] ?? null);
        $this->setCountry($data['country'] ?? null);
        $this->setLatitude($data['latitude'] ?? null);
        $this->setLongitude($data['longitude'] ?? null);

        return $this;
    }

    /*
     * @return mixed
     */
    public function getData() {
        $result = array();
        Fields::addOptField($result, 'external_id', $this->external_id);
        Fields::addOptField($result, 'type', $this->type);
        Fields::addOptField($result, 'service_provider', $this->service_provider);
        Fields::addOptField($result, 'name', $this->name);
        Fields::addOptField($result, 'street_address', $this->street_address);
        Fields::addOptField($result, 'postal_code', $this->postal_code);
        Fields::addOptField($result, 'post_office', $this->post_office);
        Fields::addOptField($result, 'country', $this->country);
        Fields::addOptField($result, 'latitude', $this->latitude);
        Fields::addOptField($result, 'longitude', $this->longitude);

        return $result;
    }

}
