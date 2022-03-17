<?php

namespace Posti\Glue;

use Posti\Glue\Logger;

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
     * @var bool
     */
    
    private $test = false;

    /*
     * @var string
     */
    
    private $contract_number = null;

    /*
     * @var string
     */
    
    private $business_id = null;

    /*
     * @var Logger
     */
    
    private $logger;

    /*
     * @var string
     */
    
    private $last_status = false;

    /*
     * @param string $username
     * @param string $password
     * @param string $business_id
     * @param string $contract_number
     * @param bool $test_mode
     */
    
    public function __construct($username, $password, $business_id, $contract_number, $test_mode = false) {
        $this->username = $username;
        $this->password = $password;
        $this->business_id = $business_id;
        $this->contract_number = $contract_number;

        if ($test_mode) {
            $this->test = true;
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
     * @return string
     */
    
    private function getApiUrl() {
        if ($this->test) {
            return "https://argon.ecom-api.posti.com/ecommerce/v3/";
        }
        return "https://ecom-api.posti.com/ecommerce/v3/";
    }
    
    /*
     * @return string
     */

    public function getBusinessId() {
        return $this->business_id;
    }

    /*
     * @return string
     */
    
    private function getAuthUrl() {
        if ($this->test) {
            return "https://oauth2.barium.posti.com";
        }
        return "https://oauth2.posti.com";
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

        $token_data = json_decode($this->getPostiToken($this->getAuthUrl() . "/oauth/token?grant_type=client_credentials", $this->username, $this->password));

        if (isset($token_data->access_token)) {
            $this->token = $token_data->access_token;
            return $token_data;
        }
        return false;
    }

    /*
     * @param string $url
     * @param string $data
     * @param string $action
     * @retrun mixed
     */
    
    private function ApiCall($url, $data = '', $action = 'GET') {
        if (!$this->token) {
            $this->getToken();
        }

        $env = $this->test ? "TEST " : "PROD ";
        $curl = curl_init();
        $header = array();

        $header[] = 'Authorization: Bearer ' . $this->token;

        if ($data) {
            $this->logger->log("info", $data);
        }

        if ($action == "POST" || $action == "PUT") {
            $payload = json_encode($data);

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
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $action);
        }
        if ($action == "GET" && is_array($data)) {
            $url .= '?' . http_build_query($data);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_URL, $this->getApiUrl() . $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $this->logger->log("info", $env . " " . $action . " Request to: " . $url . "\nResponse: " . json_encode($result));

        if (!$result) {
            $this->logger->log("error", $http_status . ' - response from ' . $url . ': ' . $result);
            return false;
        }


        if ($http_status != 200) {
            $this->logger->log("error", $env . " " . $action . "Request to: " . $url . "\nResponse code: " . $http_status . "\nResult: " . $result);
            return false;
        }
        return json_decode($result, true);
    }

    /*
     * @return mixed
     */

    public function getWarehouses() {
        $warehouses = $this->ApiCall('catalogs?role=RETAILER', '', 'GET');
        if (is_array($warehouses) && isset($warehouses['content'])) {
            $warehouses = $warehouses['content'];
        } else {
            $warehouses = array();
        }

        return $warehouses;
    }

    /*
     * @param string $id
     * @return mixed
     */

    public function getProduct($id) {
        $product_data = $this->ApiCall('inventory/' . $id, '', 'GET');
        $product = new Product();
        var_dump($product_data);
        return $product->fillData($product_data);
    }

    /*
     * @param string $id
     * @return mixed
     */

    public function getProductsByWarehouse($id, $attrs = '') {
        $products_data = $this->ApiCall('catalogs/' . $id . '/products', $attrs, 'GET');
        $products = [];
        if (is_array($products_data) && isset($products_data['content'])) {
            foreach ($products_data['content'] as $data) {
                $product = new Product();
                if ($product->fillData($data) === false) {
                    $this->logger->log("error", 'Failed to create product from: ' . json_encode($data));
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

    public function addProduct($products) {
        $products_data = [];
        if (!is_array($products)) {
            $products = [$products];
        }
        foreach ($products as $product) {
            $products_data[] = $product->getData();
        }
        $status = $this->ApiCall('inventory', $products_data, 'PUT');
        return $status;
    }

    /*
     * @param string $order
     * @return mixed
     */

    public function addOrder($order) {
        $status = $this->ApiCall('orders', $order->getData(), 'POST');
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
        $status = $this->ApiCall('orders/' . $order_id, '', 'GET');
        return $status;
    }
    
    /*
     * @param string $order_id
     * @return mixed
     */

    public function deleteOrder($order_id) {
        $status = $this->ApiCall('orders/' . $order_id, '', 'DELETE');
        return $status;
    }

    /*
     * @param $url
     * @param $user
     * @param $secret
     * @return bool|string
     */
    private function getPostiToken($url, $user, $secret) {
        $headers = array();

        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Basic ' . base64_encode("$user:$secret");

        $options = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            //CURLOPT_USERAGENT       => $this->user_agent,
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
