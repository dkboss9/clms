<?php

/**
 * Description of Me
 *
 * @author sbnull
 */
class Presets extends Api_Controller {

    public function __construct() {
        parent::__construct();

        $this->_handle_request_authentication();
        $this->load->model("api_model");
    }


    public function upload_photo_post(){
        $user_id = $this->_get_request_user_id(); 

        $user = $this->api_model->get_user($user_id);

        if (empty($user)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        if(empty($_FILES)){
            $this->response([
                'message' => 'File is not uploaded',
                'errors' => 'File is not uploaded',
            ], self::HTTP_NOT_FOUND);
            return;
        }
        
        $config['upload_path'] = './uploads/document/';
        $config['allowed_types'] = '*';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        
        
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('files')) {
                $this->response([
                'message' => 'Ops, Something goes wrong.',
                'errors' => strip_tags($this->upload->display_errors()),
                ], self::HTTP_NOT_FOUND);
                return;
        } else {
            $arr_image = $this->upload->data();
            $imagename = base_url("uploads/document/").$arr_image["file_name"];
            $this->db->where("userid",$user_id);
            $this->db->update("users",["picture"=>$arr_image["file_name"]]);

            $this->response([
                'code' => 200,
                'message' => 'Picture has been uploaded Successfuly.',
                'source' => $imagename,
                    ], Api_Controller::HTTP_OK);
        }
    }

    public function upload_documents_post(){
        $user_id = $this->_get_request_user_id(); 

        $user = $this->api_model->get_user($user_id);

        if (empty($user)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        if(empty($_FILES)){
            $this->response([
                'message' => 'File is not uploaded',
                'errors' => 'File is not uploaded',
            ], self::HTTP_NOT_FOUND);
            return;
        }
        
        $config['upload_path'] = './uploads/student_documents/';
        $config['allowed_types'] = '*';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        
        
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('files')) {
                $this->response([
                'message' => 'Ops, Something goes wrong.',
                'errors' => strip_tags($this->upload->display_errors()),
                ], self::HTTP_NOT_FOUND);
                return;
        } else {
            $arr_image = $this->upload->data();
            $imagename = base_url("uploads/student_documents/").$arr_image["file_name"];
            $this->response([
                'message' => 'Document has been uploaded Successfuly.',
                'src' => $imagename,
                'file_name' => $arr_image["file_name"],
                    ], Api_Controller::HTTP_OK);
        }
    }

    public function document_categories_get(){
        $user_id = $this->_get_request_user_id(); 

        $user = $this->api_model->get_user($user_id);

        if (empty($user)) {
            $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $datas =  $this->api_model->listall_documentcategory($user_id)->result();
        $this->response($datas, Api_Controller::HTTP_OK);
    }

   
}