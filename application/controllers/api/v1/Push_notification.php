<?php

use App\Enums\UserTypes;

class Push_notification extends Api_Controller
{
    public function __construct()
    {
        parent::__construct();

        // all methods in this controller need to have valid jwt authentication
           $this->_handle_request_authentication();
    }

   

    public function register_device_token_post()
    {
         $user_id = $this->_get_request_user_id(); 

         $this->load->model("users/users_model");

        $users = $this->users_model->get_user($user_id);

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $token = $this->post('token');
        $device_type = $this->post('device_type');
        $device_identifier = $this->post('device_identifier');


        $validation_data = [
            'token' => $token,
            'device_type' => $device_type,
            'device_identifier' => $device_identifier,
        ];

        $validation_rules = [
            [
                'field' => 'token',
                'rules' => 'required',
            ],
            [
                'field' => 'device_type',
                'rules' => 'required|max_length[255]',
            ],
            [
                'field' => 'device_identifier',
                'rules' => 'required|max_length[255]',
            ],
        ];

        $this->load->library('form_validation');
        $this->form_validation->set_data($validation_data);
        $this->form_validation->set_rules($validation_rules);

        if (!$this->form_validation->run()) {
            $this->response([
                'code' => 400,
                'message' => 'Validation Failed',
                'errors' => $this->form_validation->error_array(),
            ], self::HTTP_BAD_REQUEST);
            return;
        }

        $this->db->where(["unique_device_identifier"=>$device_identifier,"type" => $device_type])->delete("push_tokens");

         $token_array = [
            'owner_id'=>$user_id,
            "unique_device_identifier"=>$device_identifier,
            "owner_type"=>"FRONT_USER",
            "type" => $device_type,
            'token'=>$token
        ];

        
        $this->db->insert("push_tokens",$token_array);
        
        $this->response([
            'code' => 200,
            'message' => 'Successful.',
        ], self::HTTP_OK);

    }


}
