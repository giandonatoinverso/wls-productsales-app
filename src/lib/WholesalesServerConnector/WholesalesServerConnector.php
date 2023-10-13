<?php

require_once 'config/config.php';
require_once BASE_PATH . '/lib/HttpRequester/HttpRequester.php';
require_once BASE_PATH . '/lib/AuthManager/AuthManager.php';

class WholesalesServerConnector {
    private string $host = '';
    private HttpRequester $http_request;

    function __construct() {
        $this->host = WHOLESALES_SERVER;
        $this->http_request = new HttpRequester();
    }

    private function get($url, $token = "", $data = array()) {

        $header = array(
            "ClientId: " . CLIENT_ID,
            "ClientSecret: " . CLIENT_SECRET,
            "Authorization: Bearer " . $token
        );

        $result = $this->http_request->get($url, $header, $data);

        if(isset($result["error"]))
            throw new Exception($result["error"], $result["httpCode"]);
        else
            return $result;
    }

    private function post($url, $token = "", $data = array()) {

        $header = array(
            "ClientId: " . CLIENT_ID,
            "ClientSecret: " . CLIENT_SECRET,
            "Authorization: Bearer " . $token,
            "Content-Type: application/json"
        );

        $result = $this->http_request->post($url, $header, $data);

        if(isset($result["error"]))
            throw new Exception($result["error"], $result["httpCode"]);
        else
            return $result;
    }

    public function testKey() {
        $url = $this->host . "wholesales/testKey/";

        try {
            $result = $this->get($url);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    /** Prodotti */

    public function getProdotti() {

        $url = $this->host . "wholesales/prodotti";

        try {
            $result = $this->get($url);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getProdotto($id_prodotto) {

        $url = $this->host . "wholesales/prodotti/" . $id_prodotto;

        try {
            $access_token = $_SESSION["auth_manager"]->getAccessToken();
            $result = $this->get($url, $access_token);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function addProdotto($prodotto) {

        $url = $this->host . "wholesales/prodotti/new/";

        try {
            $access_token = $_SESSION["auth_manager"]->getAccessToken();
            $result = $this->post($url, $access_token, $prodotto);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function editProdotto($prodotto) {

        $url = $this->host . "wholesales/prodotti/edit/";

        try {
            $access_token = $_SESSION["auth_manager"]->getAccessToken();
            $result = $this->post($url, $access_token, $prodotto);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function deleteProdotto($id_prodotto) {

        $url = $this->host . "wholesales/prodotti/delete/";

        $data = array(
            "idProdotto" => $id_prodotto
        );

        try {
            $access_token = $_SESSION["auth_manager"]->getAccessToken();
            $result = $this->post($url, $access_token, $data);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    /** Vendite */

    public function getVendite() {

        $url = $this->host . "wholesales/";

        try {
            $access_token = $_SESSION["auth_manager"]->getAccessToken();
            $result = $this->get($url, $access_token);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getVendita($id_vendita) {

        $url = $this->host . "wholesales/vendite/" . $id_vendita;

        try {
            $access_token = $_SESSION["auth_manager"]->getAccessToken();
            $result = $this->get($url, $access_token);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function addVendita($vendita) {

        $url = $this->host . "wholesales/vendite/new/";

        try {
            $access_token = $_SESSION["auth_manager"]->getAccessToken();
            $result = $this->post($url, $access_token, $vendita);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function editVendita($vendita) {

        $url = $this->host . "wholesales/vendite/edit/";

        try {
            $access_token = $_SESSION["auth_manager"]->getAccessToken();
            $result = $this->post($url, $access_token, $vendita);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function deleteVendita($id_vendita) {

        $url = $this->host . "wholesales/vendite/delete/";

        $data = array(
            "idVendita" => $id_vendita
        );

        try {
            $access_token = $_SESSION["auth_manager"]->getAccessToken();
            $result = $this->post($url, $access_token, $data);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function debug($data) {
        echo '<pre>' . var_export($data, true) . '</pre>';
        exit();
    }
}