<?php

require_once 'config/config.php';
require_once BASE_PATH . '/lib/HttpRequester/HttpRequester.php';

class OauthServerConnector {
    private string $host = '';
    private HttpRequester $http_request;

    public function __construct() {
        $this->host = OAUTH_SERVER;
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

    public function startOauthAuthentication() {
        header(
            "Location: ". OAUTH_FRONTEND .
            "?callback=" . base64_encode(base_url() . "/oauth_callback.php") .
            "&clientId=" . CLIENT_ID .
            "&clientSecret=" . CLIENT_SECRET
        );
        exit();
    }

    public function testKey() {
        $url = $this->host . "oauth/testKey/";

        try {
            $result = $this->get($url);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function exchangeAuthorizationCodeAccessToken($authorizationCode) {
        $url = $this->host . "oauth/authorizationCodeAccessToken/";

        try {
            $result = $this->get($url, $authorizationCode);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function exchangeRefreshTokenAccessToken($refreshToken) {

        $url = $this->host . "oauth/refreshTokenAccessToken/";

        try {
            $result = $this->get($url, $refreshToken);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getUserScopes($accessToken) {

        $url = $this->host . "oauth/userScopes/";

        try {
            $result = $this->get($url, $accessToken);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getUtente($username, $accessToken) {

        $url = $this->host . "utenti/username/" . $username;

        try {
            $result = $this->get($url, $accessToken);
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