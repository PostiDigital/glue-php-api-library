<?php

namespace Posti\Glue\Order;

class Item
{
    /*
     * @var string
     */

    private $external_product_id;

    /*
     * @var string
     */
    private $product_ean;

    /*
     * @var string
     */
    private $product_description;

    /*
     * @var string
     */
    private $warehouse_id;

    /*
     * @var integer
     */
    private $quantity;

    /*
     * @param string $external_product_id
     * @return Item
     */

    public function setExternalProductId($external_product_id) {
        $this->external_product_id = $external_product_id;
        return $this;
    }

    /*
     * @return string
     */

    public function getExternalProductId() {
        return $this->external_product_id;
    }

    /*
     * @param string $product_ean
     * @return Item
     */

    public function setProductEan($product_ean) {
        $this->product_ean = $product_ean;
        return $this;
    }

    /*
     * @return string
     */

    public function getProductEan() {
        return $this->product_ean;
    }

    /*
     * @param string $product_description
     * @return Item
     */

    public function setProductDescription($product_description) {
        $this->product_description = $product_description;
        return $this;
    }

    /*
     * @return string
     */

    public function getProductDescription() {
        return $this->product_description;
    }

    /*
     * @param string $warehouse_id
     * @return Item
     */

    public function setWarehouseId($warehouse_id) {
        $this->warehouse_id = $warehouse_id;
        return $this;
    }

    /*
     * @return string
     */

    public function getWarehouseId() {
        return $this->warehouse_id;
    }

    /*
     * @param integer $quantity
     * @return Item
     */

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    /*
     * @return integer
     */

    public function getQuantity() {
        return $this->quantity;
    }

}
