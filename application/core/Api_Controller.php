<?php

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Base class for all REST API related controller.
 */
abstract class Api_Controller extends REST_Controller {

    private $access_token;
    private $decoded_token;

    public function __construct() {
        parent::__construct();

        $this->_allow_cross_site_access();
        $this->_initialise_auth();
    }

  
    private function _initialise_auth() {
        $this->load->config('montessori');
        $config = [
            'key' => $this->config->item('montessori_jwt_secret'),
        ];

        $this->load->library('jwt_authentication', $config);
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

    /**
     * Handles API response for single data
     * @param type $data Data
     */
    protected function _respond_single(array $data) {
        $this->response($data);
    }

    /**
     * Handles API response for multiple data
     * @param type $data Data
     * @param type $total Total records in database
     * @param type $per_page Limit used for selecting the records
     * @param type $page Offset used for selecting the records
     */
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

    protected function _generate_tokens($user_id, $email) {
        $issued_at = time();

        $access_token_body = [
            'user_id' => $user_id,
            'email' => $email,
            'type' => 'access',
        ];

        $access_token = $this->jwt_authentication->generate_access_token(
                $access_token_body, ['expiry_time' => '+365 days','iat' => $issued_at]
        );

        $refresh_token_body = [
            'user_id' => $user_id,
            'email' => $email,
            'type' => 'refresh',
        ];

        $refresh_token = $this->jwt_authentication->generate_access_token(
                $refresh_token_body, ['expiry_time' => '+365 days', 'iat' => $issued_at]
        );

        return [
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'issued_at' => $issued_at
        ];
    }

    protected function _handle_request_authentication() {
        $auth_token = $this->jwt_authentication->get_bearer_token();
        $decoded_token = $this->jwt_authentication->decode_access_token($auth_token);
    //   print_r($decoded_token); die();
        if ($decoded_token === NULL || !$this->_is_valid_access_token($decoded_token)) {
            // invalid token

            $this->_send_unauthenticated_respopnse();
            return;
        }

        $this->access_token = $auth_token;
        $this->decoded_token = $decoded_token;
    }

    protected function _is_valid_access_token($token) {
        $is_valid = FALSE;
        if (
                isset($token['type']) && $token['type'] === 'access' &&
                isset($token['email']) &&
                isset($token['user_id'])
        ) {
            $is_valid = TRUE;
        }

        return $is_valid;
    }

    protected function _decode_token($token) {
        return $this->jwt_authentication->decode_access_token($token);
    }

    protected function _is_valid_refresh_token($token) {
        $is_valid = FALSE;
        if (
                isset($token['type']) && $token['type'] === 'refresh' &&
                isset($token['email']) &&
                isset($token['user_id'])
        ) {
            $is_valid = TRUE;
        }

        return $is_valid;
    }

    protected function _get_request_user_id() {
        if (!isset($this->decoded_token['user_id'])) {
            throw new Exception('Must call _handle_request_authentication()');
        }
        return $this->decoded_token['user_id'];
    }

    /**
     * @return \Api_Request
     */
    protected function _get_api_request() {
        $page = $this->query('page');
        $per_page = $this->query('per_page');
        $revision = $this->query('revision');
        $data = [
            'page' => $page,
            'per_page' => $per_page,
            'revision' => $revision,
        ];
        $req = new Api_Request($data);
        return $req;
    }

    protected function _authenticate_user() {
        $this->load->library('jwt_authentication');

        $this->token = $this->jwt_authentication->get_bearer_token();
        $this->decoded = $this->jwt_authentication->decode_access_token($this->token);

        return $this->decoded !== NULL;
    }

    protected function _get_user_id() {
       

         $auth_token = $this->jwt_authentication->get_bearer_token();
        $decoded_token = $this->jwt_authentication->decode_access_token($auth_token);


        $this->access_token = $auth_token;
        $this->decoded_token = $decoded_token;
        
        return $this->decoded_token['user_id']??0;
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

    protected function _get_sync_params() {
        $per_page = (int) $this->get('per_page');
        $last_revision = (int) $this->get('last_revision') ?: 0;

        $per_page = $per_page < 10 ? 10 : ($per_page > 100 ? 100 : $per_page);

        return [
            'per_page' => $per_page,
            'last_revision' => $last_revision,
        ];
    }

    protected function _get_pagination_params() {
        $per_page = (int) $this->get('per_page');
        $page = (int) $this->get('page') ?: 1;

        $per_page = $per_page < 10 ? 10 : ($per_page > 100 ? 100 : $per_page);
        $page = $page < 1 ? 1 : $page;

        $offset = ($page - 1) * $per_page;
        $limit = $per_page;

        return [
            'per_page' => $per_page,
            'page' => $page,
            'limit' => $limit,
            'offset' => $offset,
        ];
    }

}
