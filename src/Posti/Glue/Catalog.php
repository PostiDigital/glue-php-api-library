<?php

namespace Posti\Glue;

class Catalog
{
    /*
     * @var string
     */

    private $external_id;

    /*
     * @var string
     */
    private $catalog_type;

    /*
     * @var string
     */
    private $catalog_name;

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
    private $back_order_allowed;

    /*
     * @var string
     */
    private $priority;

    /*
     * @var string
     */
    private $route_weight;

    /*
     * @var string
     */
    private $public;

    /*
     * @param string $external_id
     * @return Catalog
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
     * @param string $catalog_type
     * @return Catalog
     */

    public function setCatalogType($catalog_type) {
        $this->catalog_type = $catalog_type;
        return $this;
    }

    /*
     * @return string
     */

    public function getCatalogType() {
        return $this->catalog_type;
    }

    /*
     * @param string $catalog_name
     * @return Catalog
     */

    public function setCatalogName($catalog_name) {
        $this->catalog_name = $catalog_name;
        return $this;
    }

    /*
     * @return string
     */

    public function getCatalogName() {
        return $this->catalog_name;
    }

    /*
     * @param string $supplier_id
     * @return Catalog
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
     * @return Catalog
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
     * @param string $back_order_allowed
     * @return Catalog
     */

    public function setBackOrderAllowed($back_order_allowed) {
        $this->back_order_allowed = $back_order_allowed;
        return $this;
    }

    /*
     * @return string
     */

    public function getBackOrderAllowed() {
        return $this->back_order_allowed;
    }

    /*
     * @param string $priority
     * @return Catalog
     */

    public function setPriority($priority) {
        $this->priority = $priority;
        return $this;
    }

    /*
     * @return string
     */

    public function getPriority() {
        return $this->priority;
    }

    /*
     * @param string $route_weight
     * @return Catalog
     */

    public function setRouteWeight($route_weight) {
        $this->route_weight = $route_weight;
        return $this;
    }

    /*
     * @return string
     */

    public function getRouteWeight() {
        return $this->route_weight;
    }

    /*
     * @param string $public
     * @return Catalog
     */

    public function setPublic($public) {
        $this->public = $public;
        return $this;
    }

    /*
     * @return string
     */

    public function getPublic() {
        return $this->public;
    }
    
    /*
     * @param array $data
     * @return Catalog
     */

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

}
