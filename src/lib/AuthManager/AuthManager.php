<?php

require_once BASE_PATH . '/lib/OauthServerConnector/OauthServerConnector.php';
require_once BASE_PATH . '/lib/WholesalesServerConnector/WholesalesServerConnector.php';

class AuthManager {
    private OauthServerConnector $oauthServerConnector;
    private WholesalesServerConnector $wholesalesServerConnector;

    public function __construct() {
        $this->oauthServerConnector = new OauthServerConnector();
        $this->wholesalesServerConnector = new WholesalesServerConnector();
        $this->testKey();
    }

    /** Cookies **/
    private  function checkAllCookies() {
        if(!$this->checkRefreshToken() || !$this->checkUserCookies())
            return false;

        return true;
    }

    private function checkUserCookies() {
        if(!isset($_COOKIE['userData']) || !isset($_COOKIE['scopes']))
            return false;

        return true;
    }

    private  function checkRefreshToken() {
        if(!isset($_COOKIE['refreshToken']) || !isset($_COOKIE['refreshTokenExpiration']))
            return false;

        if(strtotime($_COOKIE['refreshTokenExpiration']) < time())
            return false;

        return true;
    }

    /** start user authentication (Authorization code) **/
    public function startUserAuthentication() {
        $this->oauthServerConnector->startOauthAuthentication();
    }

    /** Test key **/
    public function testKey() {
        try {
            $oauthConnection = $this->oauthServerConnector->testKey();

            if($oauthConnection["httpCode"] == 0)
                die("Oauth server connection failed");

            $wholesalesConnection = $this->wholesalesServerConnector->testKey();

            if($wholesalesConnection["httpCode"] == 0)
                die("wholesales server connection failed");

        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage(), "index.php");
        }
    }

    /** Exchange Authorization code for access Token and refresh Token **/
    public function exchangeAuthorizationCodeAccessToken($authorizationCode) {
        try {
            $result = $this->oauthServerConnector->exchangeAuthorizationCodeAccessToken($authorizationCode);

            $this->setRefreshToken($result["data"]["refreshToken"], $result["data"]["refreshTokenExpiration"]);

            $output = array(
                "accessToken" => $result["data"]["accessToken"],
                "refreshToken" => $result["data"]["refreshToken"],
                "refreshTokenExpiration" => $result["data"]["refreshTokenExpiration"]
            );

            return $output;
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage(), "index.php");
        }
    }

    /** Scopes **/
    public function verifyScopes($input_scopes, $fail = true, $rule = null) {
        if (!$this->checkRefreshToken() || !$this->getScopes()) {
            if ($fail) {
                $this->startUserAuthentication();
            } else {
                return false;
            }
        }

        $userScopes = $this->getScopes();

        // Default rule: all input scopes are mandatory
        if ($rule === null) {
            $rule = function ($input_scopes, $userScopes) {
                foreach ($input_scopes as $scope) {
                    $indice = array_search($scope, $userScopes);

                    if ($indice === false)
                        return false;
                }

                return true;
            };
        }

        // Verify rule
        if (!$rule($input_scopes, $userScopes)) {
            if ($fail) {
                $this->failure("Privilegi insufficienti", "index.php");
            } else {
                return false;
            }
        }

        return true;
    }


    /** Exchange refresh Token for access token **/
    public function getAccessToken($refreshTokenInput = null) {
        $refreshToken = "";
        if($refreshTokenInput == null && !$this->checkRefreshToken())
            $this->startUserAuthentication();
        else if($refreshTokenInput != null)
            $refreshToken = $refreshTokenInput;
        else
            $refreshToken = $this->getRefreshToken();

        try {
            if(!$refreshToken)
                throw new Exception("Invalid refresh token", 500);

            $result = $this->oauthServerConnector->exchangeRefreshTokenAccessToken($refreshToken);

            $this->setRefreshToken($result["data"]["refreshToken"], $result["data"]["refreshTokenExpiration"]);

            return $result["data"]["accessToken"];
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage(), "index.php");
        }
    }

    /** setter */
    public function setScopes($accessToken, $expiration) {
        try {
            $result = $this->oauthServerConnector->getUserScopes($accessToken);
            $scopes = serialize(array_values($result['data']));

            $expires = strtotime($expiration);
            setcookie('scopes', $scopes, $expires, '/');
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage(), "index.php");
        }
    }

    public function setUserData($username, $accessToken, $expiration) {
        try {
            $result = $this->oauthServerConnector->getUtente($username, $accessToken);
            $userData = serialize(array_values($result['data']));
            $expires = strtotime($expiration);

            setcookie('userData', $userData, $expires, '/');
        } catch(Exception $e) {
            $this->failure($e->getCode() . " " . $e->getMessage(), "index.php");
        }
    }

    private function setRefreshToken($refreshToken, $refreshTokenExpiration) {
        $expires = strtotime($refreshTokenExpiration);

        setcookie('refreshToken', $refreshToken, $expires, '/');
        setcookie('refreshTokenExpiration', $refreshTokenExpiration, $expires, '/');
    }

    /** getter **/
    public function getUserData() {
        if(!$this->checkUserCookies())
            return false;

        return unserialize($_COOKIE['userData']);
    }

    public function getScopes() {
        if(!$this->checkUserCookies())
            return false;

        return unserialize($_COOKIE['scopes']);
    }

    private function getRefreshToken() {
        if(!$this->checkRefreshToken())
            return false;

        return $_COOKIE['refreshToken'];
    }

    /** Utilities **/
    public function failure($message, $location ) {
        $_SESSION['failure'] = $message;
        header("Location: ". $location);
        exit();
    }

    public function success($message, $location) {
        $_SESSION['success'] = $message;
        header("Location: ". $location);
        exit();
    }

    public function debug($data) {
        echo '<pre>' . var_export($data, true) . '</pre>';
        exit();
    }
}