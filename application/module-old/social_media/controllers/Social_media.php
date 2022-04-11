<?php
class social_media extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('social_mediamodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'social_media';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('social_media/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['social_media'] 	= $this->social_mediamodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //--------------------------------------add--------------------------------------	
    function add() {
       // date_default_timezone_set("Asia/Kathmandu"); 
      date_default_timezone_set("Australia/Sydney"); 
      if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
        if ($this->input->post('submit')) {
            if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $userdata = $this->session->userdata("clms_front_userid");
            $date = date("Y-m-d");
            $data['values']['content']	= $this->input->post('details');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $dates = $this->input->post('date');
            $dates = explode("/", $dates);
            $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
            $data['values']['shedule_date']   = strtotime($date);
            $data['values']['schedule_time']              = $this->input->post("event_time");
            $data['values']['tweet_time']  = $this->input->post("tweet_time");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->social_mediamodel->add($data['values']);
            $id = $this->db->insert_id();
            $config['upload_path']   = './uploads/media/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = '2048';
            foreach($_FILES as $key => $value) {
                if(!empty($_FILES[$key]['name'])){ 
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload($key)) { 
                        $errors[] = $this->upload->display_errors();
                            //print_r($errors);die();
                    }else{ 
                        $uploads = array($this->upload->data()); 
                        //print_r($uploads);
                        foreach($uploads as $key => $value){ 
                            $image = $value['file_name'];
                            $details['images']['filename']  = $image;
                            $details['images']['social_id'] = $id;
                            $this->db->insert("socail_files",$details['images']);
                        }
                    }
                }
            }
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage social_media",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);

            if($this->input->post("tweet_time")==1){
               redirect('social_media/tweet/'.$id);
           }
           $this->session->set_flashdata('success_message', 'social media added successfully');

           redirect('social_media/listall');
       }else{
        $data['page'] = 'add';
        $data['heading'] = 'Add ';
        $this->load->vars($data);
        $this->load->view($this->container);
    }
} else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
}
}

    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('media_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['content']  = $this->input->post('details');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $dates = $this->input->post('date');
            $dates = explode("/", $dates);
            $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
            $data['values']['shedule_date']   = strtotime($date);
            $data['values']['schedule_time']              = $this->input->post("event_time");
            $data['values']['tweet_time']  = $this->input->post("tweet_time");
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;

            $this->social_mediamodel->update($id, $data['values']);
            $config['upload_path']   = './uploads/media/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = '2048';
            foreach($_FILES as $key => $value) {
                if(!empty($_FILES[$key]['name'])){ 
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload($key)) { 
                        $errors[] = $this->upload->display_errors();
                            //print_r($errors);die();
                    }else{ 
                        $uploads = array($this->upload->data()); 
                        //print_r($uploads);
                        foreach($uploads as $key => $value){ 
                            $image = $value['file_name'];
                            $details['images']['filename']  = $image;
                            $details['images']['social_id'] = $id;
                            $this->db->insert("socail_files",$details['images']);
                        }
                    }
                }
            }
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage social_media",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'social_media edited Successfully');
            redirect('social_media/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->social_mediamodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('start/listall');
            }
        }
    }
}

function tweet(){
    $id = $this->uri->segment(3);
    $tweet = $this->social_mediamodel->getdata($id)->row();
    $this->db->where("social_id",$tweet->id);
    $files = $this->db->get("socail_files")->result();
    $media_files = array();
    foreach ($files as $file) {
        array_push($media_files, "./uploads/media/".$file->filename);
    }

    require_once ('../src/codebird.php');
    $users = $this->db->where("userid",$tweet->added_by)->get("users")->row();
\Codebird\Codebird::setConsumerKey($users->consumer_key, $users->consumer_secret); // static, see 'Using multiple Codebird instances'

$cb = \Codebird\Codebird::getInstance();

$cb->setToken($users->access_token, $users->access_secret);

$media_ids = array();

foreach ($media_files as $file) {
    // upload all media files
    $reply = $cb->media_upload(array(
        'media' => $file
        ));
    // and collect their IDs
    //$media_ids[] = $reply->media_id_string;
    array_push($media_ids, $reply->media_id_string);
}


$media_ids = implode(',', $media_ids);
//echo strlen($media_ids);
// send tweet with these medias
if(strlen($media_ids)>0)
    $reply = $cb->statuses_update(array(
        'status' => $tweet->content,
        'media_ids' => $media_ids
        ));
else
    $cb->statuses_update('status='.$tweet->content);

$this->db->where("id",$tweet->id);
$this->db->set("is_shared",1);
$this->db->update("social_media");
$this->session->set_flashdata('success_message', 'Tweeted successfully');
redirect('social_media/listall');
}

    //------------------------delete---------------------------------------------------------	

function delete_documents(){
    $imageid = $this->input->post("id");
    $this->db->where("id",$imageid);
    $this->db->delete("socail_files");
}
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('social_media',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage social_media",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->social_mediamodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('social_media/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function detail() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
        $id = $this->uri->segment(3);
        $query = $this->industrymodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result'] = $query->row();
            $row = $query->row();
            $query->free_result();
            $data['title'] = $row->option_name.' - Option';
            $data['page'] = 'detail';
            $this->load->view('main', $data);
        } else {
            redirect('industry/listall');
        }
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function cascadeAction() {
    $data = $_POST['object'];
    $ids = $data['ids'];
    $action = $data['action'];
    foreach ($ids as $key => $delid) {
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('social_media',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage social_media",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->social_mediamodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}