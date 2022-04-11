<?php
class Subscribers extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->container = 'main';
    $this->load->model('subscribermodel');
    $this->load->model('users/usermodel');
    $this->module_code = 'SUBSCRIBERS';
  }

  function index() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      redirect('subscribers/listall', 'location');
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

    //----------------------------------------listall--------------------------------------------------	
  function listall() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      $config['base_url'] = base_url() . 'subscribers/listall/';
      $config['uri_segment'] = 3;
      $config['per_page'] = 20;
      $config['cur_tag_open'] = '<span class="active">';
      $config['cur_tag_close'] = '</span>';
      $config['first_link'] = FALSE;
      $config['last_link'] = FALSE;
      $config['display_pages'] = FALSE;
      $config['next_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
      $config['prev_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
      $config['next_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
      $config['prev_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
      $config['next_tag_open'] = '';
      $config['next_tag_close'] = '';
      $config['prev_tag_open'] = '';
      $config['prev_tag_close'] = '';
      $config['num_tag_open'] = '';
      $config['num_tag_close'] = '';
            //$query = $this->subscribermodel->listall();
      $data['subscribers'] = $this->subscribermodel->listall();
           /* $config['total_rows'] = $query->num_rows();
            $this->pagination->initialize($config);
            $query->free_result();
            $page = $this->uri->segment(3, 0);
            $limit = array("start" => $config['per_page'], "end" => $page);
            $query = $this->subscribermodel->listall($limit);
            if ($query->num_rows() > 0) {
                $subscribers = '';
                foreach ($query->result() as $row):
					$publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
                    $subscribers .= '<tr>
									<td><input type="checkbox" class="checkone" value="' . $row->subscription_id . '" /></td>
									<td>'.$row->email_address. '</td>
									<td>' . $row->name . '</td>
									<td>' . $row->subscription_date . '</td>
									<td>'.anchor('subscribers/edit/'.$row->subscription_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('subscribers/delete/'.$row->subscription_id,'<span class="glyphicon glyphicon-trash"></span>',array('onclick'=>"if(confirmationBox()){return true;} return false;")).'</td>';
                    $subscribers .= '</tr>';
                endforeach;
                $query->free_result();
            }else {
                $subscribers = '';
                $subscribers .= '<tr><td colspan="4" style="text-align:center;">No records exist.</td></tr>';
            }

            $initial = ($page + 1) > $config['total_rows'] ? $config['total_rows'] : ($page + 1);
            $final = ($page + $config['per_page']);
            $string = $initial . " - " . (($config['total_rows'] > $final) ? $final : $config['total_rows']) . " of " . $config['total_rows'];
            $data['heading'] 		= 'Subscribers';
            $data['pagenumbers'] 	= $string;
            $data['subscribers'] 	= $subscribers;
            $data['pagination'] 	= $this->pagination->create_links(); */
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
            $data['values']['email_address'] 			= $this->input->post('email_address');		
            if(!$this->subscribermodel->checkifexists($data['values']['email_address'] )){							
             $userdata = $this->session->userdata("clms_front_userid");
             $date = date("Y-m-d");
             $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
             $data['values']['email_address'] 			= $this->input->post('email_address');
             $data['values']['name'] 					= $this->input->post('name');
             $data['values']['subscription_date'] 		= $this->input->post('subscription_date');
             $data['values']['added_date'] 				= $date;
             $data['values']['added_by'] 				= $userdata;
             $data['values']['modified_date'] 			= $date;
             $data['values']['modified_by'] 				= $userdata;
             $data['values']['status'] 					= $this->input->post('status');
             $this->subscribermodel->add($data['values']);
             $logs = array(
              "content" => serialize($data['values']),
              "action" => "Add",
              "module" => "Manage Subscribers",
              "added_by" => $this->session->userdata("clms_front_userid"),
              "added_date" => time()
              );
             $this->usermodel->insertUserlog($logs);
             $this->session->set_flashdata('success_message', 'Subscriber added successfully');
             redirect('subscribers/listall');
           } else {
             $this->session->set_flashdata('error', 'Email address: '. $data['values']['email_address'] .' already exists');
             $data['page'] = 'add';
             $data['heading'] = 'Add Subscriber';
             $this->load->vars($data);
             $this->load->view($this->container);
           }
           
         } else {
          $data['page'] = 'add';
          $data['heading'] = 'Add Subscriber';
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
          $old_email_address = $this->input->post('old_email_address');					
          $data['values']['email_address'] 			= $this->input->post('email_address');			
          $exists = false;
          if($old_email_address != $this->input->post('email_address')) {
           $exists = $this->subscribermodel->checkifexists($data['values']['email_address'] );
         }				
         if(!$exists){
           $id = $this->input->post('id');
           $userdata = $this->session->userdata("clms_front_userid");
           $date = date("Y-m-d");
           $data['values']['name'] 					= $this->input->post('name');
           $data['values']['subscription_date'] 		= $this->input->post('subscription_date');
           $data['values']['added_date'] 				= $date;
           $data['values']['added_by'] 				= $userdata;
           $data['values']['modified_date'] 			= $date;
           $data['values']['modified_by'] 				= $userdata;
           $data['values']['status'] 					= $this->input->post('status');
           $this->subscribermodel->update($id, $data['values']);
           $logs = array(
            "content" => serialize($data['values']),
            "action" => "Edit",
            "module" => "Manage Subscribers",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
           $this->usermodel->insertUserlog($logs);
           $this->session->set_flashdata('success_message', 'Subscriber Edited Successfully');
           redirect('subscribers/listall');
         } else {
           $this->session->set_flashdata('error', 'Email address: '. $data['values']['email_address'] .' already exists');
           $id = $this->uri->segment(3);
           $query = $this->subscribermodel->getdata($id);
           if ($query->num_rows() > 0) {
            $data['result'] 	= $query->row();
            $data['page'] 		= 'edit';
            $data['heading'] 	= 'Edit Subscriber';
            $this->load->view('main', $data);
          } else {
            redirect('subscribers/listall');
          }
        }
      } else {
        $id = $this->uri->segment(3);
        $query = $this->subscribermodel->getdata($id);
        if ($query->num_rows() > 0) {
          $data['result'] 	= $query->row();
          $data['page'] 		= 'edit';
          $data['heading'] 	= 'Edit Subscriber';
          $this->load->view('main', $data);
        } else {
          redirect('subscribers/listall');
        }
      }
    }
  }

    //------------------------delete---------------------------------------------------------	
  function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
      $delid = $this->uri->segment('3');
      $cond = array("subscription_id"=>$delid);
      $content = $this->usermodel->getDeletedData('newsletter_subscription',$cond);
      $logs = array(
        "content" => serialize($content),
        "action" => "Delete",
        "module" => "Manage Subscribers",
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_date" => time()
        );
      $this->usermodel->insertUserlog($logs);
      $this->subscribermodel->delete($delid);
      $this->session->set_flashdata('success_message', 'Subscriber deleted successfully');
      redirect('subscribers/listall');
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

    //---------------------detail---------------------------------
  function detail() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      $id = $this->uri->segment(3);
      $query = $this->subscribermodel->getdata($id);
      if ($query->num_rows() > 0) {
        $data['result'] = $query->row();
        $row = $query->row();
        $query->free_result();
        $data['title'] = $row->newsletter_title.' - Newsletter Details';
        $data['page'] = 'detail';
        $this->load->view('main', $data);
      } else {
        redirect('subscribers/listall');
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
      $cond = array("subscription_id"=>$delid);
      $content = $this->usermodel->getDeletedData('newsletter_subscription',$cond);
      $logs = array(
        "content" => serialize($content),
        "action" => $action,
        "module" => "Manage Subscribers",
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_date" => time()
        );
      $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->subscribermodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
    echo '';
    exit();
  }

  function validateemail(){		
    $email_address = $this->input->post('email_address');
    if($this->subscribermodel->checkifexists($email_address))
     echo 1;
   else
     echo 0;
 }

}