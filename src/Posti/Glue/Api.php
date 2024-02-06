<?php

namespace Posti\Glue;

use Posti\Glue\Logger;
use Posti\Glue\InventoryItem;
use Posti\Glue\Catalog;
use Posti\Glue\PickupPoint;

class Api
{
    /*
     * @var string
     */

    private $username = null;

    /*
     * @var string
     */
    private $password = null;

    /*
     * @var string
     */
    private $token = null;

    /*
     * @var string
     */
    private $token_expire = null;

    /*
     * @var bool
     */
    private $test = false;

    /*
     * @var string
     */
    private $user_agent = null;

    /*
     * @var Logger
     */
    private $logger;

    /*
     * @var string
     */
    private $last_status = false;

    /*
     * @var string
     */
    private $auth_url = null;

    /*
     * @var string
     */
    private $api_url = null;

    /*
     * @param string $username
     * @param string $password
     * @param string $user_agent
     * @param bool $test_mode
     */

    public function __construct($username, $password, $user_agent, $test_mode = false) {
        $this->username = $username;
        $this->password = $password;
        $this->user_agent = $user_agent;

        if ($test_mode) {
            $this->test = $test_mode;
        }

        $this->logger = new Logger();
    }

    /*
     * @param bool $value
     * @return Api
     */

    public function setDebug($value, $file = false) {
        $this->logger->setDebug($value, $file);
        return $this;
    }

    /*
     * @return string
     */

    public function getLastStatus() {
        return $this->last_status;
    }

    /*
     * @param string $url
     * @return Api
     */

    public function setApiUrl($url) {
        $this->api_url = $url;
        return $this;
    }

    /*
     * @return string
     */

    private function getApiUrl() {
        if ($this->api_url) {
            return $this->api_url;
        }
        if ($this->test) {
            return "https://argon.ecom-api.posti.com";
        }
        return "https://ecom-api.posti.com";
    }

    /*
     * @param string $url
     * @return Api
     */

    public function setAuthUrl($url) {
        $this->auth_url = $url;
        return $this;
    }

    /*
     * @return string
     */

    private function getAuthUrl() {
        if ($this->auth_url) {
            return $this->auth_url;
        }
        return $this->getApiUrl();
    }

    /*
     * @param string $token
     * @return Api
     */

    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    /*
     * @return mixed
     */

    public function getToken() {
        if ($this->token) {
            return $this->token;
        }
        $token_data = json_decode($this->createToken($this->getAuthUrl() . "/auth/token", $this->username, $this->password));

        if (isset($token_data->access_token)) {
            $this->token = $token_data->access_token;
            //add token 10 minutes expire
            $this->token_expire = time() + $token_data->expires_in - 600;
            return $this->token;
        }
        return false;
    }

    /*
     * @return mixed
     */

    public function getTokenExpire() {
        return $this->token_expire;
    }
    
    /*
     * @param string $url
     * @param string $data
     * @param string $action
     * @retrun mixed
     */
    
    private function ApiCallFetchPages($url, $data = '', $action = 'GET', $page = 0) {
        if (!$this->token) {
            $this->getToken();
        }
        $env = $this->test ? "TEST " : "";
        $curl = curl_init();
        $header = array();
        
        $header[] = 'Authorization: Bearer ' . $this->token;
        
        $payload = '';
        if ($data) {
            $payload = json_encode($data);
        }
        
        if ($action == "POST" || $action == "PUT") {
            $header[] = 'Content-Type: application/json';
            $header[] = 'Content-Length: ' . strlen($payload);
            if ($action == "POST") {
                curl_setopt($curl, CURLOPT_POST, 1);
            } else {
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $action);
            }
            curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        }
        if ($action == "DELETE") {
            if (!empty($payload)) {
                $header[] = 'Content-Type: application/json';
                $header[] = 'Content-Length: ' . strlen($payload);
                
                curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
            }
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $action);
        }
        
        if ($action == 'GET' && $page > 0) {
            if (!is_array($data) && $data == '') {
                $data = array();
            }
            $data['page'] = $page;
        }
        if ($action == "GET" && is_array($data)) {
            $url .= '?' . http_build_query($data);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_ENCODING , "");
        curl_setopt($curl, CURLOPT_URL, $this->getApiUrl() . $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->user_agent);

        $result = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->last_status = $http_status;
        curl_close($curl);

        if ($http_status < 200 || $http_status >= 300) {
            $this->logger->log('error', $env . "HTTP $http_status : $action request to $url" . ( isset($payload) ? " with payload:\r\n $payload" : '' ) . "\r\n\r\nand result:\r\n $result");
            return false;
        }
        $result_data = json_decode($result, true);
        
        $result_content = $result_data['content'] ?? $result_data;
        if (isset($result_data['page']) && $result_data['page']['totalPages'] > ($page + 1)) {
            $page_response = $this->ApiCallFetchPages($url, $data, $action, $page + 1);
            if (!empty($page_response)) {
                $result_content = array_merge($result_content, $page_response);
            }
        }
        return $result_content;
    }
    
    private function ApiCall($url, $data = '', $action = 'GET') {
        if (!$this->token) {
            $this->getToken();
        }

        $env = $this->test ? 'TEST ': '';
        $curl = curl_init();
        $header = array();
        
        $header[] = 'Authorization: Bearer ' . $this->token;
        $payload = null;
        if ('POST' == $action || 'PUT' == $action || 'DELETE' == $action) {
            $payload = json_encode($data);
            
            $header[] = 'Content-Type: application/json';
            $header[] = 'Content-Length: ' . strlen($payload);
            if ('POST' == $action) {
                curl_setopt($curl, CURLOPT_POST, 1);
            } else {
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $action);
            }
            curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        } elseif ('GET' == $action && is_array($data)) {
            $url .= '?' . http_build_query($data);
        }
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $this->getApiUrl() . $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->user_agent);
        
        $result = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->last_status = $http_status;

        if ($http_status < 200 || $http_status >= 300) {
            $this->logger->log('error', $env . "HTTP $http_status : $action request to $url" . ( isset($payload) ? " with payload:\r\n $payload" : '' ) . "\r\n\r\nand result:\r\n $result");
            return false;
        }
        
        return json_decode($result, true);
    }

    /*
     * @return mixed
     */

    public function getWarehouses() {
        return $this->getCatalogs();
    }

    /*
     * @return mixed
     */

    public function getCatalogs() {
        $catalogs_data = $this->ApiCallFetchPages('/ecommerce/v3/catalogs?role=RETAILER', '', 'GET');
        if (!is_array($catalogs_data)) {
            $catalogs_data = array();
        }
        $catalogs = [];
        foreach ($catalogs_data as $data) {
            $catalog = new Catalog();
            if ($catalog->fillData($data) === false) {
                $this->logger->log("error", 'Failed to create catalog from: ' . json_encode($data));
                continue;
            }
            $catalogs[] = $catalog;
        }
        return $catalogs;
    }

    /*
     * @param string $id
     * @return mixed
     */

    public function getInventoryItem($id) {
        $product_data = $this->ApiCall('/ecommerce/v3/inventory/' . urlencode($id), '', 'GET');
        $product = new InventoryItem();
        return $product->fillData($product_data);
    }

    /*
     * @param string $id
     * @return mixed
     */

    public function getInventoryItemsByCatalog($catalogExternalId, $retailerId, $attrs = '') {
        $products_data = $this->ApiCallFetchPages('/ecommerce/v3/inventory?retailerId=' . $retailerId . '&catalogExternalId=' . $catalogExternalId, $attrs, 'GET');
        $products = [];
        if (is_array($products_data)) {
            foreach ($products_data as $data) {
                $product = new InventoryItem();
                if ($product->fillData($data) === false) {
                    $this->logger->log("error", 'Failed to create inventory item from: ' . json_encode($data));
                    continue;
                }
                $products[] = $product;
            }
        }
        return $products;
    }

    /*
     * @param array $products
     * @return mixed
     */

    public function addInventoryItems($products) {
        $products_data = [];
        if (!is_array($products)) {
            $products = [$products];
        }
        foreach ($products as $product) {
            $products_data[] = $product->getData();
        }
        $status = $this->ApiCall('/ecommerce/v3/inventory', $products_data, 'PUT');
        return $status;
    }

    /*
     * @param string $productExternalId
     * @return mixed
     */

     public function deleteInventoryItem($productExternalId) {
         $payload = [['product' => ['externalId' => $productExternalId, 'status' => 'EOS']]];
         $status = $this->ApiCall('/ecommerce/v3/inventory', $payload, 'DELETE');
         return $status;
    }

    public function getBalancesUpdatedSince($catalog_id, $dttm_since, $size, $page = 0) {
        if (!isset($dttm_since) || !isset($catalog_id)) {
            return [];
        }
        
        return $this->ApiCall('/ecommerce/v3/catalogs/' . urlencode($catalog_id) . '/balances?modifiedFromDate=' . urlencode($dttm_since) . '&size=' . $size . '&page=' . $page, '', 'GET');
    }
    
    public function getBalancesUpdatedSinceForProduct($catalog_id, $dttm_since = null, $product_external_id = null, $size, $page = 0) {
        if (!isset($catalog_id)) {
            return [];
        }

        if (!isset($dttm_since) && !isset($product_external_id)) {
            return [];
        }

        $params = array();
        if ($product_external_id) {
            $params['productExternalId'] = $product_external_id;
        }

        if ($dttm_since) {
            $params['modifiedFromDate'] = $dttm_since;
        }

        $params['size'] = $size;
        $params['page'] = $page;

        return $this->ApiCall('/ecommerce/v3/catalogs/' . urlencode($catalog_id) . '/balances', $params, 'GET');
    }

    /*
     * @param string $catalog_id
     * @param string $date
     * @return mixed
     */
    public function getCatalogOrders($catalog_id = null, $date = null) {
        $params = null;
        if ($catalog_id || $date) {
            $params = array();
            if ($catalog_id) {
                $params['warehouseExternalId'] = $catalog_id;
            }

            if ($date) {
                $params['updatedFrom'] = date('c', strtotime($date));
            }
        }

        return $this->ApiCallFetchPages('/ecommerce/v3/orders', $params, 'GET');
    }

    /*
     * @param Order $order
     * @return mixed
     */

    public function addOrder($order) {
        $status = $this->ApiCall('/ecommerce/v3/orders', $order->getData(), 'POST');
        if ($status !== false) {
            return $status['externalId'] ?? false;
        }
        return $status;
    }

    /*
     * @param Order $order
     * @return mixed
     */

    public function updateOrder($order, $data = null) {
        if (empty($data)) {
            $status = $this->ApiCall('/ecommerce/v3/orders/' . urlencode($order->getExternalId()), $order->getData(), 'PUT');
        } else {
            $glue_order_id = $order;
            $status = $this->ApiCall('/ecommerce/v3/orders/' . urlencode($glue_order_id), $data, 'PUT');
        }
        if ($status !== false) {
            return $status['externalId'] ?? false;
        }
        return $status;
    }

    /*
     * @param string $order_id
     * @return mixed
     */

    public function getOrder($order_id) {
        $status = $this->ApiCall('/ecommerce/v3/orders/' . urlencode($order_id), '', 'GET');
        return $status;
    }

    public function getServices( $workflow) {
        $services = $this->ApiCall('/ecommerce/v3/services', array('workflow' => urlencode($workflow)) , 'GET');
        return $services;
    }

    /*
     * @param string $order_id
     * @return mixed
     */

    public function deleteOrder($order_id) {
        $status = $this->ApiCall('/ecommerce/v3/orders/' . urlencode($order_id), '', 'DELETE');
        return $status;
    }
    
    public function getPickupPoints($postcode = null, $street_address = null, $country = null, $city = null, $service_code = null, $type = null) {
        if ((null == $postcode && null == $street_address)
            || ('' == trim($postcode) && '' == trim($street_address))) {
            return array();
        }

        $response = $this->ApiCall('/ecommerce/v3/pickup-points'
            . '?serviceCode=' . urlencode($service_code)
            . '&postalCode=' . urlencode($postcode)
            . '&postOffice=' . urlencode($city)
            . '&streetAddress=' . urlencode($street_address)
            . '&country=' . urlencode($country)
            . '&type=' . urlencode($type), '', 'GET');
        if (!is_array($response)) {
            return [];
        }

        $result = array();
        foreach ($response as $p) {
            $pickupPoint = new PickupPoint();
            $pickupPoint->fillData($p);
            $result[] = $pickupPoint;
        }

        return $result;
    }

    /*
     * @param $url
     * @param $user
     * @param $secret
     * @return bool|string
     */

    private function createToken($url, $user, $secret) {
        $headers = array();

        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Basic ' . base64_encode("$user:$secret");

        $options = array(
            CURLOPT_POST => 0,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_USERAGENT => $this->user_agent,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => $headers,
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

}
