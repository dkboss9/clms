<?php

use \Firebase\JWT\JWT;

class Jwt_authentication {
    private $key = NULL;
    private $claims = [
        'iss' => 'http://outlines-rnd.com.np',
        'aud' => 'http://outlines-rnd.com.np',
    ];
    private $algorithm = 'HS256';
    private $expiry_time = '+365 days';

    public function __construct($params = []) {
        isset($params['key']) && $this->key = $params['key'];
        isset($params['algorithm']) && $this->algorithm = $params['algorithm'];
        isset($params['expiry_time']) && $this->expiry_time = $params['expiry_time'];
        isset($params['claims']) && is_array($params['claims']) && $this->claims += $params['claims'];  // merge provided claims

        if (empty($this->key) || !is_string($this->key) || $this->key === '<JWT SECRET HERE>') {
            // JWT secret has NOT been set. die !!!
            // throw new Exception('JWT Secret not set or set to default');
            die('JWT Secret not set or set to default.');
        }
    }

    /**
     * @return string token used for subsequent api calls
     * @param array $token_body Description
     */
    public function generate_access_token(array $token_body = [], array $config = []) {
        $expiry_time = $config['expiry_time'] ?? $this->expiry_time;
        $issued_at = $config['iat'] ?? time();
        $expire_at = strtotime($expiry_time, $issued_at);
        $claims = $token_body + $this->claims + [
            'iat' => $issued_at,
            'exp' => $expire_at,
        ];
        return JWT::encode($claims, $this->key, $this->algorithm);
    }

    /**
     * Decodes token
     * @return array decoded value of token
     */
    public function decode_access_token($token) {
        try {
            $decoded = (array) JWT::decode($token, $this->key, [$this->algorithm]);
        } catch (Exception $ex) {
            $decoded = NULL;
        }
        return $decoded;
    }

    /**
     * Get header Authorization
     * */
    public function get_authorization_header() {
        $auth_header = NULL;
        if (isset($_SERVER['Authorization'])) { 
            $auth_header = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            // echo 'two';
            $auth_header = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } else if (function_exists('apache_request_headers')) {
            // echo 'three';
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            // print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $auth_header = trim($requestHeaders['Authorization']);
            }
        }
        return $auth_header;
    }

    /**
     * get access token from header
     * */
    public function get_bearer_token() {
        $auth_header = $this->get_authorization_header();
        // HEADER: Get the access token from the header
        if (!empty($auth_header) && preg_match('/Bearer\s(\S+)/i', $auth_header, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
