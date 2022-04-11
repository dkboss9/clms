<?php
/**
 * Description of Auth
 *
 * @author sbnull
 */
class Upload extends Api_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("custom_upload");
    }


  function _createThumbnail($fileName, $thumb, $width=100, $height=100) {
    $config = array();
    $config['image_library'] = 'gd2';
    $config['source_image'] = $fileName;
    $config['new_image'] = FCPATH . $thumb;
    $config['create_thumb'] = TRUE;
    $config['maintain_ratio'] = TRUE;
    $config['width'] =  $width;
    $config['height'] = $height;
  
    $this->load->library('image_lib');
    $this->image_lib->initialize($config);
    if (!$this->image_lib->resize()) {
      echo $this->image_lib->display_errors();
      return false;
    }
    return $this->image_lib->data();
  }

  function upload_customer_profile_picture_post(){
    $this->_handle_request_authentication();
    $user_data = $this->_get_request_user_id(); 
    $userid = $user_data['userid'];
    $user_type = $user_data['user_type'];

    $this->load->model("api_model");

    $company = $this->api_model->getCustomerDetail($userid);

    if (empty($company)) {
       $this->_respond_error('User Not Found', self::HTTP_INTERNAL_SERVER_ERROR);
       return;
   }

    if(empty($_FILES)){
      $this->response([
        'message' => 'File is not uploaded',
        'errors' => 'File is not uploaded',
      ], self::HTTP_NOT_FOUND);
  
    }
    $type = $_FILES['files']['type'];
  
      $config['upload_path'] = './assets/uploads/users/';
      $config['allowed_types'] = 'png|jpg|jpeg|gif';
    
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
      } else {
        $arr_image = $this->upload->data();
        $imagename = $arr_image['file_name']; 
        $thumb = $this->_createThumbnail('./assets/uploads/users/' . $arr_image['file_name'], './assets/uploads/users/thumb',174,69);
        $image_array['src'] = base_url("assets/uploads/users/thumb/".$thumb["dst_file"]);

        $this->db->where("id",$userid);
        $this->db->update("customer_front",[
          "photo"=>$arr_image['file_name'],
          "thumbnail"=>$thumb["dst_file"]
        ]);
        $image_array['type'] = $type;
        $this->response([
            'code' => 200,
            'message' => 'File has been uploaded Successfuly.',
            'source' => $image_array,
                ], Api_Controller::HTTP_OK);
      }
  }

  
}
