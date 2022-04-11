<?php

namespace App;

use App\REST_Controller\REST_Controller;

class ApiController extends REST_Controller
{
    protected $access_token;
    protected $decoded_token;

    protected $config_key_jwt_secret;

    public function __construct()
    {
        parent::__construct();

        $this->_allow_cross_site_access();
        $this->_initialise_auth();
    }

    /**
     * Allow Cross-Origin Request
     * Provides CORS headers like 'Access-Control-Allow-Origin'
     */
    private function _allow_cross_site_access() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

        // OPTIONS requests are stopped
        if ($this->input->method(TRUE) === 'OPTIONS') {
            die();
        }
    }

    protected function _initialise_auth()
    {
        $config = [
            'key' => $this->config->item($this->config_key_jwt_secret),
        ];

        $this->load->library('jwt_authentication', $config);
    }

    /**
     * Override this method to customise generated token
     *
     * @param array $token_body
     * @return array
     */
    protected function _decorate_token_body(array $token_body) : array
    {
        return $token_body;
    }

    protected function _generate_tokens($user_id, $email, array $extra_fields = [])
    {
        $issued_at = time();

        $token_body = [
            'user_id' => $user_id,
            'email' => $email,
        ] + $extra_fields;

        $token_body = $this->_decorate_token_body($token_body);

        $access_token_body = [
            'type' => 'access',
        ] + $token_body;

        $access_token = $this->jwt_authentication->generate_access_token(
            $access_token_body, ['iat' => $issued_at]
        );

        $refresh_token_body = [
            'type' => 'refresh',
        ] + $token_body;

        $refresh_token = $this->jwt_authentication->generate_access_token(
            $refresh_token_body, ['expiry_time' => '+30 day', 'iat' => $issued_at]
        );

        return [
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'issued_at' => $issued_at
        ];
    }

    protected function _get_request_user_id() {
        if (!isset($this->decoded_token['user_id'])) {
            throw new Exception('Must call _handle_request_authentication()');
        }
        return $this->decoded_token['user_id'];
    }

    protected function _handle_request_authentication() {
        $auth_token = $this->jwt_authentication->get_bearer_token();
        $decoded_token = $this->jwt_authentication->decode_access_token($auth_token);

        if ($decoded_token === NULL || !$this->_is_valid_access_token($decoded_token)) {
            // invalid token

            $this->_send_unauthenticated_respopnse();
            return;
        }

        $this->access_token = $auth_token;
        $this->decoded_token = $decoded_token;
    }

    /**
     * Override this method with proper access token validation logic
     *
     * @param array $decoded_token
     * @return bool
     */
    protected function _is_valid_access_token(array $decoded_token) : bool {
        return false;
    }

    /**
     * Override this method with proper access token validation logic
     *
     * @param array $decoded_token
     * @return bool
     */
    protected function _is_valid_refresh_token(array $decoded_token) : bool {
        return false;
    }

    protected function _respond_single(array $data) {
        $this->response($data);
    }

    protected function _respond_multiple(array $data, array $meta = []) {
        $this->response([
            'data' => $data,
            'meta' => $meta,
        ]);
    }

    protected function _respond_error(string $message = 'Error', int $status = 500, array $errors = []) {
        $this->response([
            'code' => $status,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }

    /**
     * Displays unauthenticated message on response.
     */
    protected function _send_unauthenticated_respopnse() {
        $this->response([
            'code' => 401,
            'message' => 'Authentication Failed',
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }

    protected function _send_not_implemented_response() {
        $this->response([
            'code' => 501,
            'message' => 'Not Implemented'
        ], REST_Controller::HTTP_NOT_IMPLEMENTED);
    }

    protected function _decode_token($token) {
        return $this->jwt_authentication->decode_access_token($token);
    }
}
