<?php

namespace Winipayer\Winipayer;

class Winipayer
{

    private string $_endpoint = 'https://api.winipayer.com';
    private string $_version = 'v1';
    private string $_env;
    private string $_apply_key;
    private string $_token_key;
    private string $_private_key;

    private string $_currency = 'xof';
    private array $_channel = [];
    private array $_items = [];
    private string $_customer_owner = '';
    private array $_custom_data = [];
    private array $_store = [];
    private string $_cancel_url = '';
    private string $_wpsecure = '';
    private string $_return_url = '';
    private string $_callback_url = '';

    /**
     * Class constructor
     */
    public function __construct()
    {

        $this->_env = (in_array(config('laravel-winipayer.env'), ['prod', 'test'])) ? config('laravel-winipayer.env') : 'test';

        $this->_apply_key = !empty(config('laravel-winipayer.apply_key')) ? config('laravel-winipayer.apply_key') : $this->_apply_key;

        $this->_token_key = !empty(config('laravel-winipayer.token_key')) ? config('laravel-winipayer.token_key') : $this->_token_key;

        $this->_private_key = !empty(config('laravel-winipayer.private_key')) ? config('laravel-winipayer.private_key') : $this->_private_key;

        $this->_wpsecure = !empty(config('laravel-winipayer.wpsecure')) ? config('laravel-winipayer.wpsecure') : $this->_wpsecure;

    }

    /**
     * Change api endpoint
     *
     * @param string $url
     * @return Winipayer
     */
    public function setEndpoint(string $url): Winipayer
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Winipayer : setEndpoint => Invalid endpoint URL.');
        }

        $this->_endpoint = $url;

        return $this;
    }

    /**
     * Change cancel url
     *
     * @param string $url
     * @return Winipayer
     */
    public function setCancelUrl(string $url): Winipayer
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Winipayer : setCancelUrl => Invalid cancel URL.');
        }
        $this->_cancel_url = $url;
        return $this;
    }

    /**
     * Change return url
     *
     * @param string $enpoint New enpoint url
     * @return Winipayer
     */
    public function setReturnUrl(string $url): Winipayer
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Winipayer : setReturnUrl => Invalid return URL.');
        }
        $this->_return_url = $url;
        return $this;
    }

    /**
     * Change callback url
     *
     * @param string $enpoint New enpoint url
     * @return Winipayer
     */
    public function setCallbackUrl(string $url): Winipayer
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Winipayer : setCallbackUrl => Invalid callback URL.');
        }
        $this->_callback_url = $url;
        return $this;
    }

    /**
     * setChannel
     *
     * @param array $channel
     * @return Winipayer
     */
    public function setChannel(array $channel): Winipayer
    {
        $this->_channel = $channel;
        return $this;
    }

    /**
     * setCustomerOwner
     *
     * @param string $uuid
     * @return Winipayer
     */
    public function setCustomerOwner(string $uuid): Winipayer
    {
        if (!$this->_uuid($uuid)) {
            throw new \Exception('Winipayer : setCustomerOwner => Invalid customer owner uuid.');
        }
        $this->_customer_owner = $uuid;
        return $this;
    }

    /**
     * setWpsecure
     *
     * @param string $uuid
     * @return Winipayer
     */
    public function setWpsecure(string $wpsecure): Winipayer
    {
        if (!in_array($wpsecure, ['false', 'true'])) {

            throw new \Exception('Winipayer : setWpsecure => Invalid wpsecure.');

        }

        $this->_wpsecure = $wpsecure;

        return $this;
    }

    /**
     * setCustomData
     *
     * @param array $data
     * @return Winipayer
     */
    public function setCustomData(array $data): Winipayer
    {
        $this->_custom_data = $data;
        return $this;
    }

    /**
     * setItems
     *
     * @param array $items
     * @return Winipayer
     */
    public function setItems(array $items): Winipayer
    {

        foreach ($items as $key => $value) {

            if (!isset($value['name']) || !is_string($value['name']) || strlen($value['name']) < 2) {
                throw new \Exception('Winipayer : setItems => Invalid item name.');
            }

            if (!isset($value['quantity']) || !is_int($value['quantity'])) {
                throw new \Exception('Winipayer : setItems => Invalid item quantity.');
            }

            if (!isset($value['unit_price']) || !is_int($value['unit_price'])) {
                throw new \Exception('Winipayer : setItems => Invalid item unit_price.');
            }

            $total_price = $value['quantity'] * $value['unit_price'];

            if (!isset($value['total_price']) || !is_int($value['total_price']) || $value['total_price'] != $total_price) {
                throw new \Exception('Winipayer : setItems => Invalid item total_price.');
            }

            $this->_items[] = $value;
        }

        return $this;
    }

    public function setStore(array $store): Winipayer
    {
        $this->_store = $store;
        return $this;
    }

    /**
     * createInvoice
     *
     * @param float $amount
     * @param string $description
     * @param string $currency
     * @return array
     */
    public function createInvoice(float $amount, string $description, string $currency = 'xof'): array
    {

        $params = [
            'env' => $this->_env,
            'version' => $this->_version,
            'wpsecure' => $this->_wpsecure,
            'amount' => $amount,
            'currency' => $currency ?? $this->_currency,
            'description' => $description,
            'cancel_url' => !empty(config('laravel-winipayer.cancel_url')) ? config('laravel-winipayer.cancel_url') : $this->_cancel_url,
            'return_url' => !empty(config('laravel-winipayer.return_url')) ? config('laravel-winipayer.return_url') : $this->_return_url,
            'callback_url' => !empty(config('laravel-winipayer.callback_url')) ? config('laravel-winipayer.callback_url') : $this->_callback_url,
        ];

        if (!empty($this->_channel)) {
            $params['channel'] = $this->_channel;
        }
        if (!empty($this->_customer_owner)) {
            $params['customer_owner'] = json_encode($this->_customer_owner);
        }
        if (!empty($this->_items)) {
            $params['items'] = json_encode($this->_items);
        }
        if (!empty($this->_custom_data)) {
            $params['custom_data'] = json_encode($this->_custom_data);
        }
        if (!empty($this->_store)) {
            $params['store'] = json_encode($this->_store);
        }

        $headers = [
            'X-Merchant-Apply' => $this->_apply_key,
            'X-Merchant-Token' => $this->_token_key,
        ];

        return $this->_curl('POST', '/transaction/invoice/create', $params, $headers);
    }

    public function detailInvoice(string $uuid): array
    {

        if (!$this->_uuid($uuid)) {
            throw new \Exception('Winipayer : detailInvoice => Invalid invoice uuid.');
        }

        $params = [
            'env' => $this->_env,
            'version' => $this->_version,
        ];

        $headers = [
            'X-Merchant-Apply' => $this->_apply_key,
            'X-Merchant-Token' => $this->_token_key,
        ];

        return $this->_curl('POST', '/transaction/invoice/detail/' . $uuid, $params, $headers);
    }

    public function valideInvoice(string $uuid, float $amount): bool
    {

        if (!$this->_uuid($uuid)) {
            throw new \Exception('Winipayer : detailInvoice => Invalid invoice uuid.');
        }

        $response = $this->detailInvoice($uuid);

        if (!isset($response['success']) || $response['success'] !== true) {
            return false;
        }

        $invoice = $response['results'];

        $id = $invoice['uuid'] ?? '';
        $hash = $invoice['hash'] ?? '';
        $env = $invoice['env'] ?? '';
        $state = $invoice['state'] ?? '';
        $total = $invoice['amount'] ?? 0;

        if (
            $id !== $uuid ||
            hash('sha256', $this->_private_key) !== $hash ||
            $env !== $this->_env ||
            $state !== 'success' ||
            $total < $amount
        ) {
            return false;
        }

        return true;
    }

    /**
     * For call winipayer API
     *
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return array
     */
    private function _curl(string $method = 'POST', string $url, array $params = [], array $headers = []): array
    {

        $url = $this->_endpoint . $url;

        $headerFields = [];
        foreach ($headers as $key => $value) {
            $headerFields[] = $key . ': ' . $value;
        }

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => $params,
                CURLOPT_HTTPHEADER => $headerFields,
            )
        );

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            throw new \Exception('OrangeSms :  ' . $error);
        }

        curl_close($curl);

        return json_decode($response, true);
    }

    /**
     * Check if uuid is valide
     *
     * @param string $uuid
     * @return boolean
     */
    private function _uuid(string $uuid): bool
    {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
        return preg_match($pattern, $uuid) === 1;
    }
}