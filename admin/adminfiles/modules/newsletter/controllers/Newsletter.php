<?php
class Newsletter extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('newslettermodel');
        $this->load->model('subscribers/subscribermodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'MANAGE-NEWSLETTER';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('newsletter/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $config['base_url'] = base_url() . 'index.php/newsletter/listall/';
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
           // $query = $this->newslettermodel->listall();
            $data['newsletter'] = $this->newslettermodel->listall();
            /*$config['total_rows'] = $query->num_rows();
            $this->pagination->initialize($config);
            $query->free_result();
            $page = $this->uri->segment(3, 0);
            $limit = array("start" => $config['per_page'], "end" => $page);
            $query = $this->newslettermodel->listall($limit);
            if ($query->num_rows() > 0) {
                $newsletter = '';
                foreach ($query->result() as $row):
                   $publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
               $newsletter .= '<tr>
               <td><input type="checkbox" class="checkone" value="' . $row->newsletter_id . '" /></td>
               <td>'. anchor('newsletter/detail/'.$row->newsletter_id,$row->newsletter_title). '</td>
               <td>' . $row->newsletter_date . '</td>
               <td>'.anchor('newsletter/edit/'.$row->newsletter_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('newsletter/delete/'.$row->newsletter_id,'<span class="glyphicon glyphicon-trash"></span>',array('onclick'=>"if(confirmationBox()){return true;} return false;")).'</td>';
               $newsletter .= '</tr>';
               endforeach;
               $query->free_result();
           }else {
            $newsletter = '';
            $newsletter .= '<tr><td colspan="4" style="text-align:center;">No records exist.</td></tr>';
        }

        $initial = ($page + 1) > $config['total_rows'] ? $config['total_rows'] : ($page + 1);
        $final = ($page + $config['per_page']);
        $string = $initial . " - " . (($config['total_rows'] > $final) ? $final : $config['total_rows']) . " of " . $config['total_rows'];
       */
        $data['heading'] 		= 'Newsletters';
       // $data['pagenumbers'] 	= $string;
        //$data['newsletter'] 	= $newsletter;
        $data['pagination'] 	= $this->pagination->create_links();
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
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
        if ($this->input->post('submit')) {
           if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
            redirect($_SERVER["HTTP_REFERER"],"refresh");
        }
        $userdata = $this->session->userdata("clms_userid");
        $date = date("Y-m-d");
        $data['values']['company_id']      = $this->session->userdata("clms_company");
        $data['values']['newsletter_title'] 		= $this->input->post('newsletter_title');
        $data['values']['newsletter_description'] 	= $this->input->post('newsletter_description');
        $data['values']['newsletter_date'] 			= $date;
        $data['values']['added_date'] 				= $date;
        $data['values']['added_by'] 				= $userdata;
        $data['values']['modified_date'] 			= $date;
        $data['values']['modified_by'] 				= $userdata;
        $data['values']['status'] 					= $this->input->post('status');
        $this->newslettermodel->add($data['values']);
        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add",
            "module" => "Manage Newsletter",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'Newsletter added successfully');
        redirect('newsletter/listall');
    } else {
        $data['page'] = 'add';
        $data['heading'] = 'Add Newsletter';
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
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('id');
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $data['values']['newsletter_title'] 		= $this->input->post('newsletter_title');
            $data['values']['newsletter_description'] 	= $this->input->post('newsletter_description');
            $data['values']['newsletter_date'] 			= $date;
            $data['values']['added_date'] 				= $date;
            $data['values']['added_by'] 				= $userdata;
            $data['values']['modified_date'] 			= $date;
            $data['values']['modified_by'] 				= $userdata;
            $data['values']['status'] 					= $this->input->post('status');
            $this->newslettermodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Newsletter",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Newsletter Edited Successfully');
            redirect('newsletter/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->newslettermodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Newsletter';
                $this->load->view('main', $data);
            } else {
                redirect('newsletter/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("newsletter_id"=>$delid);
        $content = $this->usermodel->getDeletedData('newsletter',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Newsletter",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->newslettermodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('newsletter/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function detail() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
        $id = $this->uri->segment(3);
        $query = $this->newslettermodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result'] = $query->row();
            $row = $query->row();
            $query->free_result();
            $data['title'] = $row->newsletter_title.' - Newsletter Details';
            $data['page'] = 'detail';
            $this->load->view('main', $data);
        } else {
            redirect('newsletter/listall');
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
        $cond = array("newsletter_id"=>$delid);
        $content = $this->usermodel->getDeletedData('newsletter',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Newsletter",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->newslettermodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
    echo '';
    exit();
}

	//---------------------------------send--------------------------------------
function send() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('id');
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $send_to = $this->input->post('rdorec');
            $subscribers = '';
            $emaillist = '';
            switch($send_to){
             case "0":
             $query = $this->subscribermodel->listall(null,1);
             if ($query->num_rows() > 0) {
               foreach ($query->result() as $row):
                $subscribers .= $row->email_address .";";
            endforeach;
            $query->free_result();
        }
        break;
        case "1":
        $subscribers = $this->input->post('selected_subscriber');
        break;
        case "2":
        $emaillist = $this->input->post('chkemaillist');
        $len = count($emaillist);
        if($len>0)
           $subscribers = implode($emaillist, ";");
       break;
       default:

   }
   $custom_emails = $this->input->post('custom_emails');
   if($custom_emails)
     ($subscribers == '')? $subscribers .= $custom_emails. ";":$subscribers .= ";". $custom_emails;

 $subribers_email = explode(";", $subscribers);

 $query = $this->newslettermodel->getdata($id);	
 $row = $query->row();
 $site = $this->mylibrary->getSiteEmail(21);
 $this->load->library('email');				
 foreach($subribers_email as $email):
     $message = $row->newsletter_description;
 $message .= '<p>'.$this->mylibrary->getSiteEmail(21).' '.$this->mylibrary->getSiteEmail(25).'</p>
 <p>'.anchor($site.'unsubscribe?email='.$email.'&id='.$this->session->userdata('session_id'),'Unsubscribe').' from announcement emails?</p>';
 $this->email->from($this->mylibrary->getSiteEmail(22), $this->mylibrary->getSiteEmail(20));			
 $this->email->subject($row->newsletter_title);
 $this->email->message($message);
 $this->email->set_mailtype('html');	
 $this->email->to($email); 
 $this->email->send();
 $this->email->clear();
 endforeach;
 $this->session->set_flashdata('success', 'Newsletter Sent Successfully');
 redirect('newsletter/listall');
} else {
   redirect('newsletter/listall');
}
}
}

}