<?php

namespace Posti\Glue\Order;

class Address
{
    /*
     * @var string
     */

    private $id;

    /*
     * @var string
     */
    private $name;

    /*
     * @var string
     */
    private $street;

    /*
     * @var string
     */
    private $postcode;

    /*
     * @var string
     */
    private $city;

    /*
     * @var string
     */
    private $country;

    /*
     * @var string
     */
    private $telephone;

    /*
     * @var string
     */
    private $email;

    /*
     * @param string $id
     * @return Address
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
     * @param string $name
     * @return Address
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
     * @param string $street
     * @return Address
     */

    public function setStreet($street) {
        $this->street = $street;
        return $this;
    }

    /*
     * @return string
     */

    public function getStreet() {
        return $this->street;
    }

    /*
     * @param string $postcode
     * @return Address
     */

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
        return $this;
    }

    /*
     * @return string
     */

    public function getPostcode() {
        return $this->postcode;
    }

    /*
     * @param string $city
     * @return Address
     */

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    /*
     * @return string
     */

    public function getCity() {
        return $this->city;
    }

    /*
     * @param string $country
     * @return Address
     */

    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

    /*
     * @return string
     */

    public function getCountry() {
        return $this->country;
    }

    /*
     * @param string $telephone
     * @return Address
     */

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
    }

    /*
     * @return string
     */

    public function getTelephone() {
        return $this->telephone;
    }

    /*
     * @param string $email
     * @return Address
     */

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /*
     * @return string
     */

    public function getEmail() {
        return $this->email;
    }

}
