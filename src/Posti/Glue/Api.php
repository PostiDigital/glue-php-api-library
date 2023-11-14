<?php

namespace Posti\Glue;

use Posti\Glue\Logger;
use Posti\Glue\Product;
use Posti\Glue\Catalog;

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
    private $contract_number = null;

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
     * @param string $contract_number
     * @param string $user_agent
     * @param bool $test_mode
     */

    public function __construct($username, $password, $contract_number, $user_agent, $test_mode = false) {
        $this->username = $username;
        $this->password = $password;
        $this->contract_number = $contract_number;
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

    private function ApiCall($input_url, $input_data = '', $action = 'GET', $page = 0) {
        if (!$this->token) {
            $this->getToken();
        }
        $env = $this->test ? "TEST " : "";
        $curl = curl_init();
        $header = array();

        $header[] = 'Authorization: Bearer ' . $this->token;

        $data = $input_data;
        $url = $input_url;
        $payload = '';
        if ($data) {
            $this->logger->log("info", $data);
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

        $result = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $this->logger->log('info', sprintf("Request: %s\n%s %s\nHeaders\n%s\nResponse:\n%s",
            $this->getApiUrl() . $url,
            $action,
            $url,
            json_encode($header),

            base64_encode($result),
        ));
        $this->logger->log("info", $env . $action . " Request to: " . $this->getApiUrl() . $url . "\nResponse: " . $result);

        if (!$result) {
            $this->logger->log("error", $http_status . ' - response from ' . $this->getApiUrl() . $url . ': ' . $result);
            return false;
        }


        if ($http_status != 200) {
            $this->logger->log("error", $env . " " . $action . "Request to: " . $this->getApiUrl() . $url . "\nResponse code: " . $http_status . "\nResult: " . $result);
            return false;
        }
        $result_data = json_decode($result, true);

        $result_content = $result_data['content'] ?? $result_data;
        if (isset($result_data['page']) && $result_data['page']['totalPages'] > ($page + 1)) {
            $page_response = $this->ApiCall($input_url, $input_data, $action, $page + 1);
            if (!empty($page_response)) {
                $result_content = array_merge($result_content, $page_response);
            }
        }
        return $result_content;
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
        $catalogs_data = $this->ApiCall('/ecommerce/v3/catalogs?role=RETAILER', '', 'GET');
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

    public function getProduct($id) {
        $product_data = $this->ApiCall('/ecommerce/v3/inventory/' . $id, '', 'GET');
        $product = new Product();
        return $product->fillData($product_data);
    }

    /*
     * @param string $id
     * @return mixed
     */

    public function getProductsByCatalog($id, $retailerId, $attrs = '') {
        $products_data = $this->ApiCall('/ecommerce/v3/inventory?retailerId=' . $retailerId . '&catalogExternalId=' . $id, $attrs, 'GET');
        $products = [];
        if (is_array($products_data)) {
            foreach ($products_data as $data) {
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
        $status = $this->ApiCall('/ecommerce/v3/inventory', $products_data, 'PUT');
        return $status;
    }

    /*
     * @param string $productExternalId
     * @return mixed
     */

     public function deleteProduct($productExternalId) {
         $payload = [['product' => ['externalId' => $productExternalId, 'status' => 'EOS']]];
         $status = $this->ApiCall('/ecommerce/v3/inventory', $payload, 'DELETE');
         return $status;
    }

    /*
     * @param string $date
     * @return mixed
     */

    public function getBalances($date = null) {
        $data = [];
        if ($date) {
            $data['modifiedFromDate'] = date('c', strtotime($date));
        }
        $balances = $this->ApiCall('/ecommerce/v3/inventory/balances', $data, 'GET');
        return $balances;
    }

    /*
     * @param string $catalog_id
     * @param string $date
     * @return mixed
     */

    public function getCatalogBalances($catalog_id, $date = null) {
        $data = [];
        if ($date) {
            $data['modifiedFromDate'] = date('c', strtotime($date));
        }
        $balances = $this->ApiCall('/ecommerce/v3/catalogs/' . $catalog_id . '/balances', $data, 'GET');
        return $balances;
    }

    /*
     * @param string $catalog_id
     * @param string $date
     * @return mixed
     */

    public function getCatalogOrders($catalog_id, $date = null) {
        $data = [
            'warehouseExternalId' => $catalog_id
        ];
        if ($date) {
            $data['updatedFrom'] = date('c', strtotime($date));
        }
        $orders = [];
        $response = $this->ApiCall('/ecommerce/v3/orders', $data, 'GET');
        return $response;
        //TODO: create Order objects from response data
        /*
        if (is_array($response)) {
            foreach ($response as $item) {
                $order = new Order();
                $order->fillData($item);
                $orders[] = $order;
            }
            return $response;
        }
        return $response;
         *
         */
    }

    /*
     * @param string $catalog_id
     * @param string $date
     * @return mixed
     */

    public function getCatalogOrdersStatuses($catalog_id, $date = null) {
        $data = [
            'warehouseExternalId' => $catalog_id
        ];
        if ($date) {
            $data['updatedFrom'] = date('c', strtotime($date));
        }
        $statuses = [];
        $response = $this->ApiCall('/ecommerce/v3/orders', $data, 'GET');
        if (is_array($response)) {
            foreach ($response as $order_data) {
                $statuses[] = [
                    'externalId' => $order_data['externalId'],
                    'clientId' => $order_data['clientId'],
                    'status' => $order_data['status']['value'] ?? null,
                ];
            }
            return $statuses;
        }
        return $response;
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
        if (is_object($order)) {
            $status = $this->ApiCall('/ecommerce/v3/orders/' . $order->getExternalId(), $order->getData(), 'PUT');
        } else {
            $glue_order_id = $order;
            $status = $this->ApiCall('/ecommerce/v3/orders/' . $glue_order_id, $data, 'PUT');
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
        $status = $this->ApiCall('/ecommerce/v3/orders/' . $order_id, '', 'GET');
        return $status;
    }

    /*
     * @param string $order_id
     * @return mixed
     */

    public function deleteOrder($order_id) {
        $status = $this->ApiCall('/ecommerce/v3/orders/' . $order_id, '', 'DELETE');
        return $status;
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
