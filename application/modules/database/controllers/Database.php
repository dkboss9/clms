<?php
class Database extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('databasemodel');
        $this->load->model('users/usermodel');
        $this->load->model('lms/lmsmodel');
        $this->module_code = 'DATABASE';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('database/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            if($this->input->get("category"))
                $category = $this->input->get("category");
            else
                $category = "";

            $data['search_category'] = $category;

            if($this->input->get("sub_category"))
                $sub_category = $this->input->get("sub_category");
            else
                $sub_category = "";
            $data['search_sub_category'] = $sub_category;

            if($this->input->get("sub_category2"))
                $sub_category2 = $this->input->get("sub_category2");
            else
                $sub_category2 = "";
            $data['search_sub_category2'] = $sub_category2;

            if($this->input->get("sub_category3"))
                $sub_category3 = $this->input->get("sub_category3");
            else
                $sub_category3 = "";
            $data['search_sub_category3'] = $sub_category3;

            //Business category

            if($this->input->get("businesscategory"))
                $businesscategory = $this->input->get("businesscategory");
            else
                $businesscategory = "";

            $data['search_businesscategory'] = $businesscategory;

            if($this->input->get("sub_businesscategory"))
                $sub_businesscategory = $this->input->get("sub_businesscategory");
            else
                $sub_businesscategory = "";
            $data['search_sub_businesscategory'] = $sub_businesscategory;

            if($this->input->get("sub_businesscategory2"))
                $sub_businesscategory2 = $this->input->get("sub_businesscategory2");
            else
                $sub_businesscategory2 = "";
            $data['search_sub_businesscategory2'] = $sub_businesscategory2;

            if($this->input->get("sub_businesscategory3"))
                $sub_businesscategory3 = $this->input->get("sub_businesscategory3");
            else
                $sub_businesscategory3 = "";
            $data['search_sub_businesscategory3'] = $sub_businesscategory3;
            $data['databases'] 	= $this->databasemodel->listall($category,$sub_category,$sub_category2,$sub_category3,$businesscategory,$sub_businesscategory,$sub_businesscategory2,$sub_businesscategory3);
            $data['category']      = $this->databasemodel->get_category(0);
            $data['business_category']      = $this->databasemodel->get_businesscategory(0);
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
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
               if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            if($this->input->post('address') == "" && $this->input->post('phone') == "" && $this->input->post('email') == ""){
                redirect('database/add');
            }

            $userdata = $this->session->userdata("clms_front_userid");
            $date = date("Y-m-d");
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['database_name']  = $this->input->post('name');
            $data['values']['address']	= $this->input->post('address');
            $data['values']['phone']  = $this->input->post('phone');
            $data['values']['email']  = $this->input->post('email');
            $data['values']['category']              = $this->input->post('category');
            $data['values']['subcategory']              = $this->input->post('sub_category');
            $data['values']['subcategory2']              = $this->input->post('sub_category2');
            $data['values']['subcategory3']              = $this->input->post('sub_category3');
            $data['values']['subcategory4']              = $this->input->post('sub_category4');
            $data['values']['businesscategory']              = $this->input->post('businesscategory');
            $data['values']['businesssubcategory']              = $this->input->post('sub_businesscategory');
            $data['values']['businesssubcategory2']              = $this->input->post('sub_businesscategory2');
            $data['values']['businesssubcategory3']              = $this->input->post('sub_businesscategory3');
            $data['values']['businesssubcategory4']              = $this->input->post('sub_businesscategory4');
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $data['values']['db_access']      = $this->input->post("access");
            $this->databasemodel->add($data['values']);
            $id = $this->db->insert_id();
            if($this->input->post("note") != ""){
                $this->db->set("details",$this->input->post("note"));
                $this->db->set("db_id",$id);
                $this->db->set("added_date",time());
                $this->db->set("added_by",$userdata);
                $this->db->insert("database_note");
            }
            if($this->input->post("access") == 'Public'){
                $users = $this->input->post("users");
                foreach ($users as $key => $value) {
                 $insert_array = array("user_id"=>$value,'db_id'=>$id);
                 $this->db->insert("database_access",$insert_array);
             }
         }
         $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add",
            "module" => "Manage Database",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
         $this->usermodel->insertUserlog($logs);
         $this->session->set_flashdata('success_message', 'Database added successfully');
         redirect('database/listall');
     }else{
         $data['category']      = $this->databasemodel->get_category(0);
         $data['business_category']      = $this->databasemodel->get_businesscategory(0);
         $data['page'] = 'add';
         $data['heading'] = 'Add Database';
         $this->load->vars($data);
         $this->load->view($this->container);
     }
 } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
}
}

function add_note(){
   if($this->input->post("note") != ""){
     $userdata = $this->session->userdata("clms_front_userid");
     $id = $this->input->post("db_id");
     $this->db->set("details",$this->input->post("note"));
     $this->db->set("db_id",$id);
     $this->db->set("added_date",time());
     $this->db->set("added_by",$userdata);
     $this->db->insert("database_note");
     $this->session->set_flashdata('success_message', 'Database note added successfully');
     redirect('database/listall');
 }
}

function get_businesssubcategory(){
    $catid = $this->input->post("catid");
    $cats = $this->databasemodel->get_businesscategory($catid);
    if(count($cats) > 0){
        ?>
        <option value="">Select</option>
        <?php
        foreach ($cats as $cat) {
            ?>
            <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
            <?php 
        }
    }
}

    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('db_id');
            $userdata = $this->session->userdata("clms_front_userid");
           // $userdata = $this->session->userdata("clms_front_userid");
            $date = date("Y-m-d");
            $data['values']['address']  = $this->input->post('address');
            $data['values']['database_name']  = $this->input->post('name');
            $data['values']['phone']  = $this->input->post('phone');
            $data['values']['email']  = $this->input->post('email');
            $data['values']['category']              = $this->input->post('category');
            $data['values']['subcategory']              = $this->input->post('sub_category');
            $data['values']['subcategory2']              = $this->input->post('sub_category2');
            $data['values']['subcategory3']              = $this->input->post('sub_category3');
            $data['values']['subcategory4']              = $this->input->post('sub_category4');
            $data['values']['businesscategory']              = $this->input->post('businesscategory');
            $data['values']['businesssubcategory']              = $this->input->post('sub_businesscategory');
            $data['values']['businesssubcategory2']              = $this->input->post('sub_businesscategory2');
            $data['values']['businesssubcategory3']              = $this->input->post('sub_businesscategory3');
            $data['values']['businesssubcategory4']              = $this->input->post('sub_businesscategory4');
            $data['values']['modified_by']       = time();
            $data['values']['modified_date']         = $userdata;
            $data['values']['status']      = 1;
            $data['values']['db_access']      = $this->input->post("access");
            $this->databasemodel->update($id, $data['values']);

            if($this->input->post("note") != ""){
                $this->db->set("details",$this->input->post("note"));
                $this->db->set("db_id",$id);
                $this->db->set("added_date",time());
                $this->db->set("added_by",$userdata);
                $this->db->insert("database_note");
            }
            $this->db->where("db_id",$id);
            $this->db->delete("database_access");
            if($this->input->post("access") == 'Public'){
                $users = $this->input->post("users");
                foreach ($users as $key => $value) {
                 $insert_array = array("user_id"=>$value,'db_id'=>$id);
                 $this->db->insert("database_access",$insert_array);
             }
         }

         $logs = array(
            "content" => serialize($data['values']),
            "action" => "Edit",
            "module" => "Manage Database",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
         $this->usermodel->insertUserlog($logs);
         $this->session->set_flashdata('success_message', 'Database edited Successfully');
         redirect('database/listall');
     } else {
        $id = $this->uri->segment(3);
        $data['category']      = $this->databasemodel->get_category(0);
        $data['business_category']      = $this->databasemodel->get_businesscategory(0);
        $data['notes']      = $this->databasemodel->get_note($id);

        $query = $this->databasemodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result'] 	= $query->row();
            $data['page'] 		= 'edit';
            $data['heading'] 	= 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('database/listall');
        }
    }
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("db_id"=>$delid);
        $content = $this->usermodel->getDeletedData('database',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Database",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->databasemodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('database/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function change_status(){
    $id = $this->input->post("db_id");
    $status = $this->input->post("status");
    if($status == 0)
        $this->db->set("is_called",1);
    else
        $this->db->set("is_called",0);
    $this->db->where("db_id",$id);
    $this->db->update("database");
    if($status == 0){
      ?>
      <a href="javascript:void(0);" id="<?php echo $id; ?>" rel="1" class="link_status"><img src="<?php echo base_url("assets/images/done.png");?>"></a>
      <?php
  }else{
      ?>
      <a href="javascript:void(0);" id="<?php echo $id; ?>" rel="0" class="link_status"><img src="<?php echo base_url("assets/images/notdone.png");?>"></a>
      <?php
  }
}

function detail() {
       // if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
    if ($this->session->userdata("clms_front_userid") != "") {
        $id = $this->uri->segment(3);
        $data['db_id'] = $id;
        $data['result'] = $this->databasemodel->get_note($id);
        $this->load->view('detail', $data);
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}


    //---------------------detail---------------------------------


function cascadeAction() {
    $data = $_POST['object'];
    $ids = $data['ids'];
    $action = $data['action'];
    foreach ($ids as $key => $delid) {
        $cond = array("db_id"=>$delid);
        $content = $this->usermodel->getDeletedData('database',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Database",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }

    $query = $this->databasemodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

function export(){

   $this->load->dbutil();

  // $query = $this->db->query("SELECT * FROM mytable");

   $delimiter = ",";
   $newline = "\r\n";

   echo $this->dbutil->csv_from_result($databases, $delimiter, $newline);


}

function csv($filename = 'CSV_Database.csv')
{
 $query  = $this->databasemodel->listall();
 $this->load->dbutil();
 $this->load->helper('file');
 $this->load->helper('download');
 $delimiter = ",";
 $newline = "\r\n";
 $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
 force_download($filename, $data);
}

function importcsv() {
    //$data['addressbook'] = $this->csv_model->get_addressbook();
    $this->load->library('csvimport');

        $data['error'] = '';    //initialize image upload error array to empty

        $config['upload_path']   = './uploads/csv/';
        $config['allowed_types'] = 'csv|xlsx';
        $config['max_size'] = '1000';
        $this->upload->initialize($config);
        //$this->load->library('upload', $config);


        // If upload failed, display error
        if (!$this->upload->do_upload("userfile")) {
            $data['error'] = $this->upload->display_errors();
            print_r($data['error']); die();
            //$this->load->view('csvindex', $data);
        } else {
            $file_data = $this->upload->data();
            $file_path =  './uploads/csv/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                foreach ($csv_array as $row) {
                    $insert_data = array(
                        'address'=>$row['address'],
                        'email'=>$row['email'],
                        'phone'=>$row['phone'],
                        "added_by"=>$this->session->userdata("clms_front_userid"),
                        "added_date" => time()
                        );
                    $this->databasemodel->add($insert_data);
                }
                $this->session->set_flashdata('success_message', 'Csv Data Imported Succesfully');
                redirect("database/listall","");
                //echo "<pre>"; print_r($insert_data);
            } else 
            echo "Error occured";
           // $this->load->view('csvindex', $data);
        }

    } 

}