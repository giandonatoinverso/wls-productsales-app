<?php

require_once BASE_PATH . '/lib/WholesalesServerConnector/WholesalesServerConnector.php';

class Vendite {
    private WholesalesServerConnector $server;

    function __construct() {
        $this->server = new WholesalesServerConnector();
    }
    function __destruct() {}

    public function getVendite() {
        try {
            $result = $this->server->getVendite();
            return $result["data"];
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function addVendita($vendita) {
        try {
            return $this->server->addVendita($vendita);
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function editVendita($vendita) {
        try {
            return $this->server->editVendita($vendita);
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function deleteVendita($vendita) {
        try {
            return $this->server->deleteVendita($vendita);
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function getVendita($id_vendita) {
        try {
            $result = $this->server->getVendita($id_vendita);
            return $result["data"][0];
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function failure($message, $location = "vendite.php") {
        $_SESSION['failure'] = $message;
        header("Location: ". $location);
        exit();
    }

    public function success($message, $location = "vendite.php") {
        $_SESSION['success'] = $message;
        header("Location: ". $location);
        exit();
    }

    public function debug($data) {
        echo '<pre>' . var_export($data, true) . '</pre>';
        exit();
    }
}