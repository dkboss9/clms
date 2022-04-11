<?php

/**
 * Description of Me
 *
 * @author sbnull
 */
class Me extends Api_Controller {

    public function __construct() {
        parent::__construct();

        $this->_handle_request_authentication();

        $this->load->model("api_model");
    }

  

    public function profile_get() {
        $user_id = $this->_get_request_user_id(); 

        $users = $this->api_model->get_user($user_id)->row();

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

     
     if(file_exists("./uploads/document/".$users->picture) && $users->picture != "")
        $users->picture_url =  base_url("uploads/document/".$users->picture);
      else
        $users->picture_url =  base_url().'assets/images/post-thumb-1.jpg';

        $this->load->model("student/studentmodel");

        $qualifications = $this->studentmodel->getQualifications($user_id);
        $experiences = $this->studentmodel->getExperinces($user_id);

        $users->experiences = $experiences;
        $users->qualifications = $qualifications;

        $this->response($users, Api_Controller::HTTP_OK);
    }

    public function profile_post() { 
        $user_id = $this->_get_request_user_id(); 

        $users = $this->api_model->get_user($user_id)->row();

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $name = $this->post('name');
        $email = $this->post('email');
        $phone = $this->post('phone');
        $mobile = $this->post('mobile');
        $dob = $this->post('dob');
        $address = $this->post('address');
        $sex = $this->post('sex');
        $marital_status = $this->post('marital_status');


        $validation_data = [
            'name' => $this->post("name"),
            'email' => $this->post("email"),
            'phone' => $this->post("phone"),
            'mobile' => $this->post("mobile"),
            'address' => $this->post("address"),
            'sex' => $this->post("sex"),
           'marital_status' => $this->post("marital_status")
                ];

        $validation_rules = [
            [
                'field' => 'name',
                'rules' => 'required',
            ],
            [
                'field' => 'email',
                'rules' => 'required',
            ],
            [
                'field' => 'phone',
                'rules' => 'required',
            ],
            [
                'field' => 'mobile',
                'rules' => 'required',
            ],
            [
                'field' => 'address',
                'rules' => 'required',
            ],
            [
                'field' => 'sex',
                'rules' => 'required',
            ],
            [
                'field' => 'marital_status',
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

        
        $name = $this->post('name');
        $email = $this->post('email');
        $phone = $this->post('phone');
        $mobile = $this->post('mobile');
        $dob = $this->post('dob');
        $address = $this->post('address');
        $sex = $this->post('sex');
        $marital_status = $this->post('marital_status');

        $names = explode(" ", $name);

        $user_array = [
            "first_name" => $names[0],
            "last_name" => $names[1],
            "email" => $email,
            "phone" => $phone,
            "mobile" => $mobile,
            "address" => $address
        ];

        $this->db->where("userid",$user_id);
        $this->db->update("users",$user_array);

        $this->db->where("student_id",$user_id);
        $this->db->set("is_married",$marital_status);
        $this->db->set("sex",$sex);
        $this->db->update("student_details");


        $this->response([
        'code' => 200,
        'message' => 'Profile updated successfully',
            ], Api_Controller::HTTP_OK);
    }

    public function ielts_post(){
        $user_id = $this->_get_request_user_id(); 

        $users = $this->api_model->get_user($user_id)->row();

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $ielts = $this->post("ielts");
        $listening = $this->post("listening");
        $reading = $this->post("reading");
        $speaking = $this->post("speaking");
        $writing = $this->post("writing");

        $toefl = $this->post("toefl");
        $toefl_score = $this->post("toefl_score");

        $pte = $this->post("pte");
        $pte_score = $this->post("pte_score");

        $sat = $this->post("sat");
        $sat_score = $this->post("sat_score");

        $gre = $this->post("gre");
        $gre_score = $this->post("gre_score");

        $gmat = $this->post("gmat");
        $gmat_score = $this->post("gmat_score");

        $validation_data = [
            "ielts" =>$ielts,
            "toefl" => $toefl,
            "pte" => $pte,
            "sat" => $sat,
            "gre" => $gre,
            "gmat" => $gmat,
        ];

        if($ielts == 'Yes'){
            $validation_data['listening'] = $listening;
            $validation_data['reading'] = $reading;
            $validation_data['speaking'] = $listening;
            $validation_data['writing'] = $listening;
        }

        if($toefl == 'Yes'){
            $validation_data['toefl_score'] = $toefl_score;
        }

        if($pte == 'Yes'){
            $validation_data['pte_score'] = $pte_score;
        }

        if($sat == 'Yes'){
            $validation_data['sat_score'] = $sat_score;
        }

        if($gre == 'Yes'){
            $validation_data['gre_score'] = $gre_score;
        }

        if($gmat == 'Yes'){
            $validation_data['gmat_score'] = $gmat_score;
        }


        $validation_rules = [
            ['field' => 'ielts','rules' => 'required'],
            [ 'field' => 'toefl', 'rules' => 'required'],
            [ 'field' => 'pte', 'rules' => 'required'],
            [ 'field' => 'sat', 'rules' => 'required'],
            [ 'field' => 'gre', 'rules' => 'required'],
            [ 'field' => 'gmat', 'rules' => 'required']
        ];

        if($ielts == 'Yes'){
            array_push($validation_rules, ['field' => 'listening','rules' => 'required']);
            array_push($validation_rules, ['field' => 'reading','rules' => 'required']);
            array_push($validation_rules, ['field' => 'speaking','rules' => 'required']);
            array_push($validation_rules, ['field' => 'writing','rules' => 'required']);
        }

        if($toefl == 'Yes'){
            array_push($validation_rules, ['field' => 'toefl_score','rules' => 'required']);
        }

        if($pte == 'Yes'){
            array_push($validation_rules, ['field' => 'pte_score','rules' => 'required']);
        }

        if($sat == 'Yes'){
            array_push($validation_rules, ['field' => 'sat_score','rules' => 'required']);
        }

        if($gre == 'Yes'){
            array_push($validation_rules, ['field' => 'gre_score','rules' => 'required']);
        }

        if($gmat == 'Yes'){
            array_push($validation_rules, ['field' => 'gmat_score','rules' => 'required']);
        }


        
        $this->load->library('form_validation');
        $this->form_validation->set_data($validation_data);
        $this->form_validation->set_rules($validation_rules);

        if (!$this->form_validation->run()) {
            $this->response([
                'code' => 400,
                'message' => 'Validation Failed',
                'errors' => $this->form_validation->error_array(),
            ]);
            return;
        }

        $this->db->where("student_id",$user_id);
        $this->db->update("student_details",[
            "ielts" => $ielts == 'Yes' ? 1 : 0,
            "listening" => $listening,
            "reading" => $reading,
            "speaking" => $speaking,
            "writing" => $writing,
            "toefl" => $toefl == 'Yes' ? 1 : 0,
            "toefl_score" => $toefl_score,
            "pte" => $pte == 'Yes' ? 1 : 0,
            "pte_score" => $pte_score,
            "sat" => $sat == 'Yes' ? 1 : 0,
            "sat_score" => $sat_score,
            "gre" => $gre == 'Yes' ? 1 : 0,
            "gre_score" => $gre_score,
            "gmat" => $gmat == 'Yes' ? 1 : 0,
            "gmat_score" => $gmat_score,
        ]);


        $this->response([
            'code' => 200,
            'message' => 'Profile updated successfully',
                ], Api_Controller::HTTP_OK);
    }

    public function user_update_password_post()
    {
        $user_id = $this->_get_request_user_id(); 

        $users = $this->api_model->get_user($user_id)->row();

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $password = $this->post("password");
        $password_confirm = $this->post("password_confirm");

        $validation_data = [
            "password" =>$password,
            "password_confirm" => $password_confirm,
        ];

        $validation_rules = [
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
                'code' => 400,
                'message' => 'Validation Failed',
                'errors' => $this->form_validation->error_array(),
            ]);
            return;
        }

       $user_id = $this->_get_request_user_id();
      
        $this->db->where("userid",$user_id)->update("users",['password' => md5($password)]);
        $this->response([
            'code' => 200,
            'message' => 'Password has been changed Successfuly.',
                ], Api_Controller::HTTP_OK);
    }

    public function my_documents_get(){
        $this->load->model("student/studentmodel");
        $user_id = $this->_get_request_user_id(); 

        $users = $this->api_model->get_user($user_id)->row();

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $page = $this->get('page')??1;
        $offset = ($page - 1) * 10; 
        $limit = array("start" => 10, "end" => $offset);

        $data_num = $this->api_model->getDoccuments($user_id);

        $data_num = count($data_num);
    
        $total_page = $data_num / 10;
        $has_next_page = $total_page > $page ? true : false;
        $datas =  $this->api_model->getDoccuments($user_id,$limit);

        foreach($datas as $data){
            $data->doc_name = base_url("uploads/student_documents/".$data->doc_name);
        }
        $this->response([
            "datas" => $datas,
            "has_next_page" => $has_next_page,
            "current_page" => $page
        ], Api_Controller::HTTP_OK);
    }


    public function add_my_document_post(){
        $this->load->model("student/studentmodel");
        $user_id = $this->_get_request_user_id(); 

        $users = $this->api_model->get_user($user_id)->row();

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $document_name = $this->post("document_name");
        $document_type = $this->post("document_type");
        $detail = $this->post("detail");

        $validation_data = [
            "document_name" =>$document_name,
            "document_type" => $document_type,
        ];

        $validation_rules = [
            [
                'field' => 'document_name',
                'rules' => 'required',
            ],
            [
                'field' => 'document_type',
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
            ]);
            return;
        }

        $this->db->insert("doc_type",[
            "type_name" => $document_type,
            "company_id" => $user_id,
            "status" => 1,
            "added_date" => date("Y-m-d H:i:s")
        ]);

        $typeid = $this->db->insert_id();

        $this->db->insert("pnp_student_documents",[
            "student_id" => $user_id,
            "doc_type" => $typeid,
            "doc_name" => $document_name,
            "doc_desc" => $detail??""
        ]);

        $page = $this->get('page')??1;
        $offset = ($page - 1) * 10; 
        $limit = array("start" => 10, "end" => $offset);

        $data_num = $this->api_model->getDoccuments($user_id);

        $data_num = count($data_num);
    
        $total_page = $data_num / 10;
        $has_next_page = $total_page > $page ? true : false;
        $datas =  $this->api_model->getDoccuments($user_id,$limit);

        foreach($datas as $data){
            $data->doc_name = base_url("uploads/student_documents/".$data->doc_name);
        }
        $this->response([
            "datas" => $datas,
            "has_next_page" => $has_next_page,
            "current_page" => $page
        ], Api_Controller::HTTP_OK);
    }

    public function delete_my_document_post($docid=null){
        $this->load->model("student/studentmodel");
        $user_id = $this->_get_request_user_id(); 

        $users = $this->api_model->get_user($user_id)->row();

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $doc = $this->db->where("id",$docid)->get("student_documents")->row();

        if(empty($doc)){
            $this->_respond_error('Document Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        if($doc->student_id != $user_id){
            $this->_respond_error('You don\'t have permission to delete this data.', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $this->db->where("id",$docid)->delete("student_documents");

        $page = $this->get('page')??1;
        $offset = ($page - 1) * 10; 
        $limit = array("start" => 10, "end" => $offset);

        $data_num = $this->api_model->getDoccuments($user_id);

        $data_num = count($data_num);
    
        $total_page = $data_num / 10;
        $has_next_page = $total_page > $page ? true : false;
        $datas =  $this->api_model->getDoccuments($user_id,$limit);

        foreach($datas as $data){
            $data->doc_name = base_url("uploads/student_documents/".$data->doc_name);
        }
        $this->response([
            "datas" => $datas,
            "has_next_page" => $has_next_page,
            "current_page" => $page
        ], Api_Controller::HTTP_OK);

    }

    function qualification_post(){
        $this->load->model("student/studentmodel");
        $user_id = $this->_get_request_user_id(); 

        $users = $this->api_model->get_user($user_id)->row();

        if (empty($users)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $qualification_name = $this->post("qualification_name");
        $institute = $this->post("institute");
        $country = $this->post("country");
        $year_of_commence = $this->post("year_of_commence");
        $year_of_complete = $this->post("year_of_complete");
        $obtained_mark = $this->post("obtained_mark");

        $validation_data = [
            "qualification_name" =>$qualification_name,
            "institute" => $institute,
            "country" => $country,
            "year_of_commence" => $year_of_commence,
            "year_of_complete" => $year_of_complete,
            "obtained_mark" => $obtained_mark
        ];

        $validation_rules = [
            [
                'field' => 'qualification_name',
                'rules' => 'required',
            ],
            [
                'field' => 'institute',
                'rules' => 'required',
            ],
            [
                'field' => 'country',
                'rules' => 'required',
            ],
            [
                'field' => 'year_of_commence',
                'rules' => 'required',
            ],
            [
                'field' => 'year_of_complete',
                'rules' => 'required',
            ],
            [
                'field' => 'obtained_mark',
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
            ]);
            return;
        }

        $this->db->insert("student_qualification",[
            "student_id" => $user_id,
            "qualification_name" => $qualification_name,
            "institution_name" => $institute,
            "country" => $country,
            "commence_date" => $year_of_commence,
            "complete_year" => $year_of_complete,
            "percent" => $obtained_mark
        ]);

        $this->response([
            'code' => 200,
            'message' => 'Qulification has been added Successfuly.',
                ], Api_Controller::HTTP_OK);
    
    }

    
}
