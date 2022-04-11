<?php
/**
 * Description of Auth
 *
 * @author sbnull
 */
class Auth extends Api_Controller {

    public function __construct() {
         parent::__construct();
    }


    private function register_device_token($userid)
    {
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
                'message' => 'Validation Failed',
                'errors' => $this->form_validation->error_array(),
            ], self::HTTP_BAD_REQUEST);
            return;
        }

        $this->db->where(["unique_device_identifier"=>$device_identifier,"type" => $device_type])->delete("push_tokens");

         $token_array = [
            'owner_id'=>$userid,
            "unique_device_identifier"=>$device_identifier,
            "type" => $device_type,
            'token'=>$token
        ];
        
        $this->db->insert("push_tokens",$token_array);
    }


    public function authenticate_post() {
        $this->load->model("api_model");

        $email = $this->post('email');
        $password = $this->post('password');

        $validation_data = [
            'email' => $email,
            'password' => $password,
        ];

        $validation_rules = [
            [
                'field' => 'email',
                'rules' => 'required',
            ],
            [
                'field' => 'password',
                'rules' => 'required',
            ]
        ];

        $this->load->library('form_validation');
        $this->form_validation->set_data($validation_data);
        $this->form_validation->set_rules($validation_rules);

        if (!$this->form_validation->run()) {
            $this->response([
                'code' => 400,
                'message' => 'Validation Failed',
                'errors' => $this->form_validation->error_array(),
            ],self::HTTP_BAD_REQUEST);
            return;
        }

        $profile = [];

      
        $user = $this->api_model->check_customer_login($email,md5($password))->row_array();
      
        if (empty($user)) {
            $this->response([
                'code' => 401,
                'message' => 'Email or password do not match',
                    ], Api_Controller::HTTP_UNAUTHORIZED);
            return;
        }else{
            if($user['status'] == 0){
                $this->response([
                    'code' => 401,
                    'message' => 'Your account is not activated yet. Please enter the code sent in email to verify your email.',
                        ], Api_Controller::HTTP_UNAUTHORIZED);
                return;
            }
        }


        $user_id = $user['userid'];

        $users = $this->api_model->get_user($user_id)->row();

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

     
     if(file_exists("./uploads/document/".$users->picture) && $users->picture != "")
        $users->picture_url =  base_url("uploads/document/".$users->picture);
      else
        $users->picture_url =  base_url().'assets/images/post-thumb-1.jpg';

        $this->register_device_token($user_id);

        $tokens = $this->_generate_tokens($user_id, $email);

        $this->response(["tokens"=>$tokens,"profile"=>$users], Api_Controller::HTTP_OK);
    }


    
    public function signup_post() {
        $full_name = $this->post('full_name');
        $email = $this->post('email');
        $password = $this->post('password');
        $location = $this->post('location');
        $mobile_no = $this->post('mobile_no');

      

        $validation_data = [
            'email' => $email,
            'password' => $password,
            'full_name' => $full_name,
            "mobile_no" => $mobile_no,
            "location" => $location
        ];

        $validation_rules = [
            [
                'field' => 'email',
                'rules' => 'required|valid_email|max_length[255]',
            ],
            [
                'field' => 'password',
                'rules' => 'required',
            ],
         
            [
                'field' => 'full_name',
                'rules' => 'required',
            ],
         
            [
                'field' => 'mobile_no',
                'rules' => 'required',
            ],
         
            [
                'field' => 'location',
                'rules' => 'required',
            ]
        ];

        $this->load->library('form_validation');
        $this->form_validation->set_data($validation_data);
        $this->form_validation->set_rules($validation_rules);

        if (!$this->form_validation->run()) {
            $this->response([
                'message' => 'Validation Failed',
                'errors' => $this->form_validation->error_array(),
                    ], Api_Controller::HTTP_BAD_REQUEST);
            return;
        }

          $this->db->where("email",$email);
          $user = $this->db->get("users");
        if($user->num_rows() > 0){
             $this->response([
                'message' => 'Email already exists.',
                    ], Api_Controller::HTTP_BAD_REQUEST);
            return;
        }


        if(strlen($password) < 8){
            $this->response([
                'code' => 400,
                'message' => 'The password field must be at least 8 characters in length.',
                'errors' => "The password field must be at least 8 characters in length.",
                    ], Api_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $this->load->library("uuid");
        $this->load->library("mylibrary");
        $this->db->trans_start();
        $name = explode(" ",$full_name);

        $insert_array = array(
            "uuid" => $this->uuid->v4(),
            "first_name" => $name[0],
            "last_name" => $name[1],
            "email" => $email,
            "password" => md5($password),
            "phone" => $mobile_no,
            "user_group" => 14,
            "added_date" => date('Y-m-d H:i:s'),
          );

        $this->load->model("user/usermodel");
      	$this->usermodel->insertuser($insert_array);
		$userid = $this->db->insert_id();

        $this->db->insert("student_details",[
			"student_id" => $userid
		]);
        $this->db->trans_complete();
		$row = $this->generalsettingsmodel->getConfigData(82)->row();

        $this->load->model("company/companymodel");
	
		$this->companymodel->sendEmailActivation($userid);

		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$logo     = $this->mylibrary->getlogo();
		/****** get new registration template and send email to admin******/
		$row = $this->mylibrary->getEmailTemplate(63);
		$this->email->set_mailtype('html');
		$this->email->from($from, $fromname);
		$this->email->to($sitemail);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$this->email->subject($subject);
		$message = str_replace('[USER_FULL_NAME]',$full_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[ADMIN_NAME]','Admin',$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[USER_EMAIL]',$email,$message);
		$message = str_replace('[YEAR]',date('Y'),$message); 
		//$data['mail'] = $message; 
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();
	

        $this->response([
            'code' => 200,
            'message' => 'Please check your email and follow the instruction to activate your account.',
                ], Api_Controller::HTTP_OK);
    }

    function activate_user_post(){
        $email = $this->post('email');
        $code = $this->post('code');

        $validation_data = [
            'email' => $email,
            'code' => $code
        ];

        $validation_rules = [
            [
                'field' => 'email',
                'rules' => 'required|valid_email|max_length[255]',
            ],
            [
                'field' => 'code',
                'rules' => 'required',
            ]        
        ];

        $this->load->library('form_validation');
        $this->form_validation->set_data($validation_data);
        $this->form_validation->set_rules($validation_rules);

        if (!$this->form_validation->run()) {
            $this->response([
                'message' => 'Validation Failed',
                'errors' => $this->form_validation->error_array(),
                    ], Api_Controller::HTTP_BAD_REQUEST);
            return;
        }

        


        $this->load->model("api_model");
        $user = $this->api_model->check_validate_code($email,$code);


        if (empty($user)) {
            $this->response([
                'code' => 401,
                'message' => 'email or code do not match',
                    ], Api_Controller::HTTP_UNAUTHORIZED);
            return;
        }

        $user_id = $user->userid;

       $this->db->where("userid",$user_id);
       $this->db->set("verified_at",date("Y-m-d"));
       $this->db->set("status",1);
       $this->db->update("users");

        $this->response(["code"=>200,"message"=>"Your account has been activated succssfully."], Api_Controller::HTTP_OK);

    }

    public function resend_activation_code_post(){

        $email = $this->post("email");

        $validation_data = [
            'email' => $email,
        ];

        $validation_rules = [
            [
                'field' => 'email',
                'rules' => 'required',
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
            ],400);
            return;
        }

        $this->load->model("api_model");

        $user = $this->api_model->check_usersEmail_login($email)->row_array();

        if(empty($user)){
            $this->response([
                'code' => 401,
                'message' => 'User with this email is not found.',
                    ], Api_Controller::HTTP_UNAUTHORIZED);
            return;
        }

      
        $code = mt_rand(1111,9999);
       
          $userid = $user['userid'];

        $this->load->model("company/companymodel");

        $this->companymodel->sendEmailActivation($userid);
     
        $this->response([
            'code' => 200,
            'userid' => $userid,
            'message' => 'Please check your email and follow the instruction to activate your account.',
                ], Api_Controller::HTTP_OK);
      
    }

    public function social_authenticate_post(){
        $this->load->model('users/usermodel');
        $this->load->model("api_model");

        // $is_apple = $this->post("is_apple")??null;
        $token = $this->post('token');
        $email = $this->post('email')??'';
        $first_name = $this->post('first_name')??'';
        $last_name = $this->post('last_name')??'';
        $photo = $this->post("picture_path");

        $validation_data = [
            'token' => $token,
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ];


        $validation_rules = [
            [
                'field' => 'token',
                'rules' => 'required',
            ]
        ];

        $this->load->library('form_validation');
        $this->form_validation->set_data($validation_data);
        $this->form_validation->set_rules($validation_rules);

        if (!$this->form_validation->run()) {
            $this->response([
                'message' => 'Validation Failed',
                'errors' => $this->form_validation->error_array(),
            ],400);
            return;
        }

        $this->load->model("api_model");
      
        $user = $this->api_model->check_usersToken($token)->row();

        $this->load->library("uuid");
       
        if(empty($user)){
            $insert_array = array(
                "uuid" => $this->uuid->v4(),
                "email" => $email,
                "token" => $token,
                "status" => 1,
                "user_group" => 14,
                "verified_at" => date("Y-m-d"),
                "added_date" => date('Y-m-d H:i:s')
              );

          
    
            $this->load->model("user/usermodel");
              $this->usermodel->insertuser($insert_array);
            $userid = $this->db->insert_id();
    
            $this->db->insert("student_details",[
                "student_id" => $userid
            ]);
            
            $user = $this->api_model->check_usersToken($token)->row();
        }

        $tokens = $this->_generate_tokens($user->userid, $email);
        $this->response($tokens, Api_Controller::HTTP_OK);
      }

      public function forgot_password_post()
      {
  
          $email = $this->post('email');
  
          $validation_data = [
              'email' => $email,
          ];
  
          $validation_rules = [
              [
                  'field' => 'email',
                  'rules' => 'required|valid_email',
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
              ],400);
              return;
          }

          $this->load->model("api_model");
  
         $users = $this->api_model->check_usersEmail_login($email)->row_array();
  
          if (empty($users)) {
              $this->response([
                  'code' => 401,
                  'message' => 'Email do not match',
                      ], Api_Controller::HTTP_UNAUTHORIZED);
              return;
          }
  
        //  print_r( $users);die();
  
          $user_id = $users['userid'];
  
          $this->load->model("api_model");
          //$pincode = $this->generate_key();
          $code = mt_rand(1111,9999);
  
          $request_code = [
              "code" => $code,
              "code_used_at" => NULL
          ];
          $this->db->where(['userid' => $user_id])->update('users',$request_code);
  
  
          $url = base_url("change-password/".$users["uuid"]);
          $link = '<a href="'.$url.'">Click Here</a>';
          $customer = $users["first_name"].' '.$users["last_name"];   
          $from     = $this->mylibrary->getSiteEmail(32);
          $site_url = $this->mylibrary->getSiteEmail(21);
          $fromname = $this->mylibrary->getSiteEmail(20);
          $address  = $this->mylibrary->getSiteEmail(25);
          $phone    = $this->mylibrary->getSiteEmail(27);
          $fax      = $this->mylibrary->getSiteEmail(28);
          $sitemail = $this->mylibrary->getSiteEmail(23);
          $logo     = $this->mylibrary->getlogo();
          $this->email->set_mailtype('html');
          $this->email->from($sitemail, $fromname);
          $this->email->to($email);
          //$this->email->to("bikash.suwal01@gmail.com");
          $row = $this->mylibrary->getEmailTemplate(57);
         
          $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
          $this->email->subject($subject);
          $message = str_replace('[FULL_NAME]',$customer,html_entity_decode($row->email_message,ENT_COMPAT));
          $message = str_replace('[CHANGE_PASSWORD]',$link,$message);
          $message = str_replace('[CODE]',$code,$message);
          $message = str_replace('[SITE_NAME]',$fromname,$message);
          $message = str_replace('[LOGO]',$logo,$message);
          $message = str_replace('[SITE_ADDRESS]',$address,$message);
          $message = str_replace('[SITE_PHONE]',$phone,$message);
          $message = str_replace('[SITE_FAX]',$fax,$message);
          $message = str_replace('[SITE_EMAIL]',$sitemail,$message);
          $message = str_replace('[SITE_URL]',$site_url,$message);
          $message = str_replace('[YEAR]',date('Y'),$message);

          $this->email->message($message);
          $this->email->send();
        
          $this->response([
              'code' => 200,
              'message' => 'Successfull, The code has been sent to your email. Please check your email to change your password.',
                  ], Api_Controller::HTTP_OK);
        
      }

      public function verify_user_post()
      {
          $code = $this->post('code');
          $email = $this->post('email');
  
          $validation_data = [
              'code' => $code,
              'email' => $email
          ];
  
          $validation_rules = [
              [
                  'field' => 'email',
                  'rules' => 'required|valid_email',
              ],
              [
                  'field' => 'code',
                  'rules' => 'required',
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
              ],400);
              return;
          }
  
          $this->load->model("api_model");
  
          $users = $this->api_model->check_usersEmail_login($email)->row_array();
          //echo $this->db->last_query();
          if (empty($users)) {
              $this->response([
                  'code' => 401,
                  'message' => 'Email do not match',
                      ], Api_Controller::HTTP_UNAUTHORIZED);
              return;
          }
  
          $user_id = $users['userid'];
  
  
         $is_valid_code =  $this->db->where(["userid"=>$user_id,"code"=>$code,"code_used_at"=>NUll])->get("users")->num_rows();
  
         if($is_valid_code == 0){
         $this->response([
          'code' => 200,
          'message' => 'Successfull.',
              ], Api_Controller::HTTP_OK);
          }else{
                  $this->response([
                      'code' => 401,
                      'message' => 'Code do not match or expired',
                          ], Api_Controller::HTTP_UNAUTHORIZED);
                  return;
          }
      }

      public function change_password_post()
      {
          $this->load->model("api_model");
          $email = $this->post('email');
          $password = $this->post("password");
          $password_confirm = $this->post("password_confirm");
          $code = $this->post("code");
  
          $validation_data = [
              'email' => $email,
              "password" =>$password,
              "password_confirm" => $password_confirm,
              "code" => $code
          ];
  
          $validation_rules = [
              [
                  'field' => 'email',
                  'rules' => 'required|valid_email',
              ],
              [
                  'field' => 'code',
                  'rules' => 'required',
              ],
              [
                  'field' => 'password',
                  'rules' => 'required|min_length[8]',
              ],
              [
                  'field' => 'password_confirm',
                  'rules' => 'required|matches[password]',
              ],
  
          ];
  
  
          $this->load->library('form_validation');
          $this->form_validation->set_data($validation_data);
          $this->form_validation->set_rules($validation_rules);
  
          if (!$this->form_validation->run()) {
              $this->response([
                  'message' => 'Validation Failed',
                  'errors' => $this->form_validation->error_array(),
              ], Api_Controller::HTTP_UNAUTHORIZED);
              return;
          }
  
        $users = $this->api_model->check_usersEmail_login($email)->row_array();
  
          if (empty($users)) {
              $this->response([
                  'message' => 'Email do not match',
                      ], Api_Controller::HTTP_UNAUTHORIZED);
              return;
          }
  
          $user_id = $users['userid'];
  
  
         $is_valid_code =  $this->db->where(["userid"=>$user_id,"code"=>$code,"code_used_at"=>NUll])->get("users")->num_rows();
  

         if($is_valid_code == 1){
              $this->db->where("userid",$user_id)->update("users",['password' => md5($password),"code_used_at"=>date("Y-m-d H:i:s")]);
              $this->response([
                  'code' => 200,
                  'message' => 'Password has been changed Successfuly.',
                      ], Api_Controller::HTTP_OK);
          }else{
                  $this->response([
                      'code' => 401,
                      'message' => 'Code do not match or expired',
                          ], Api_Controller::HTTP_UNAUTHORIZED);
                  return;
          }
  
  
      }
    
}
