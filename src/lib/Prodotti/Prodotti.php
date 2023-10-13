<?php

require_once BASE_PATH . '/lib/WholesalesServerConnector/WholesalesServerConnector.php';

class Prodotti {
    private WholesalesServerConnector $server;

    function __construct() {
        $this->server = new WholesalesServerConnector();
    }
    function __destruct() {}

    public function getProdotti() {
        try {
            $result = $this->server->getProdotti();
            return $result["data"];
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function addProdotto($prodotto) {
        try {
            return $this->server->addProdotto($prodotto);
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function editProdotto($prodotto) {
        try {
            return $this->server->editProdotto($prodotto);
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function deleteProdotto($id_prodotto) {
        try {
            return $this->server->deleteProdotto($id_prodotto);
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function getProdotto($id_prodotto) {
        try {
            $result = $this->server->getProdotto($id_prodotto);
            return $result["data"][0];
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage());
        }
    }

    public function failure($message, $location = "index.php") {
        $_SESSION['failure'] = $message;
        header("Location: ". $location);
        exit();
    }

    public function success($message, $location = "index.php") {
        $_SESSION['success'] = $message;
        header("Location: ". $location);
        exit();
    }

    public function debug($data) {
        echo '<pre>' . var_export($data, true) . '</pre>';
        exit();
    }
}