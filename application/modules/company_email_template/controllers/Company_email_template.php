<?php
class Company_email_template extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->container = 'main';
		$this->load->model('company_emailmodel');
		$this->load->model('users/usermodel');
		$this->module_code = 'COMPANY-EMAIL';
	}
	function index(){
		if($this->session->userdata("clms_front_userid")=='' && $this->usermodel->checkperm($this->module_code,"VIEW")){
			redirect('login','location');
		}else{		
			$this->listall();
		}
	}

		//display all gallery
	function listall(){ 
		if($this->session->userdata("clms_front_userid")!='' && $this->usermodel->checkperm($this->module_code,"VIEW")){
			$config['base_url'] 		= base_url().'index.php/company_email_template/listall';
			$config['uri_segment'] = 3;
			$config['per_page'] = 30;
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
			$query = $this->company_emailmodel->listall();
			$config['total_rows'] = $query->num_rows();
			$this->pagination->initialize($config);
			$query->free_result();
			$page = $this->uri->segment(3,0);			
			$limit = array("start"=>$config['per_page'],"end"=>$page);	
			$query = $this->company_emailmodel->listall($limit);
			if($query->num_rows()>0){
				$i = 1;
				foreach($query->result() as $row){
					$data['news'][$i]['newsid'] 	= $row->email_id;
					$data['news'][$i]['title'] 		= $row->email_subject;
					$data['news'][$i]['sn'] 		= $i;
					$data['news'][$i]['description']= $row->email_desc;
					$data['news'][$i]['sms']= $row->sms;
					$data['news'][$i]['udate']		= date('Y-m-d',strtotime($row->updated_date));
					$i++;
				}
			}
			$data['heading'] 	= "Manage Email Template";
			$initial 			= ($page + 1)>$config['total_rows']?$config['total_rows']:($page+1);
			$final 				= ($page + $config['per_page']);
			$string 			= $initial . " - " . (($config['total_rows'] > $final) ? $final : $config['total_rows']) . " of " . $config['total_rows'];
			$data['pagenumbers']= $string;					
			$data['pagination'] = $this->pagination->create_links();
			$data['page'] = 'list';
			$this->load->vars($data);
			$this->load->view($this->container);
		}else{
			redirect('login','location');
		}
	}

		//display add image form and add new record
	function add(){
		if($this->session->userdata("clms_front_userid")!='' && $this->usermodel->checkperm($this->module_code,"ADD")){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('title','News Title','required');
				$this->form_validation->set_rules('newsdetails','Details','required');
				if($this->form_validation->run()==FALSE){
					$this->session->set_flashdata('error','Required field(s) missing');
					redirect('news/add','location');
				}else{
					$link 								= str_replace(' ','-',url_title($this->input->post('title'),'-',TRUE));
					$link 								= str_replace(array(',','.','&','_'),'',$link);
					if($this->session->userdata('client_id')!='0'){
						$details['news']['client_id'] 	= $this->session->userdata('client_id');
					}else{
						$details['news']['client_id'] 	= '0';
					}
					$details['news']['news_link'] 		= $link;
					$details['news']['news_title'] 		= $this->input->post('title');
					$details['news']['news_details'] 	= $this->input->post('newsdetails');
					$details['news']['added_date'] 		= date('Y-m-d');
					$details['news']['modified_date'] 	= date('Y-m-d');
					$details['news']['news_status'] 	= 1;
					$details['news']['added_by'] 		= $this->session->userdata("clms_front_userid");
					$details['news']['modified_by'] 	= $this->session->userdata("clms_front_userid");
					$this->company_emailmodel->insert($details['news']);
					$this->session->set_flashdata('success_message','News & Events added successfully');
					redirect('email_template/listall/','location');
				}
			}else{		
				$data['heading'] = "Add New News";
				$data['page'] = 'news/add';
				$this->load->vars($data);
				$this->load->view($this->container);
			}
		}else{
			redirect('login','location');
		}
	}
		//Update News Details
	function edit(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"EDIT")){
			if($this->input->post('submit')){
				$email_id  = $this->input->post('email_id');
				$this->form_validation->set_rules('title','News Title','required');
				$this->form_validation->set_rules('email_details','Details','required');
				$this->form_validation->set_rules('description','Details','required');
				if($this->form_validation->run()==FALSE){
					$this->session->set_flashdata('error','Required field(s) missing');
					redirect('company_email_template/edit/'.$email_id,'location');
				}else{
					$details['news']['email_subject'] 	= $this->input->post('title');
					$details['news']['company_id'] 	= $this->session->userdata("clms_front_companyid");
					$details['news']['email_desc'] 		= $this->input->post('description');
					$details['news']['email_message'] 	= $this->input->post('email_details');
					$details['news']['sms'] 	= $this->input->post('sms');
					$details['news']['sms_text'] 	= $this->input->post('sms_text');
					$details['news']['updated_date'] 	= date('Y-m-d H:i:s');
					$details['news']['updated_by'] 	= $this->session->userdata("clms_front_userid");
					$this->company_emailmodel->update($email_id,$details['news']);
					$this->session->set_flashdata('success_message','Email template information updated successfully');
					redirect('company_email_template/listall/','location');
				}

			}else{
				$id = $this->uri->segment(3);
				$query = $this->company_emailmodel->loaddata($id);
				if($query->num_rows()==1){
					$row = $query->row();
					$data['news']['emailid'] 	= $row->email_id;
					$data['news']['subject'] 	= $row->email_subject;
					$data['news']['email_desc'] = $row->email_desc;
					$data['news']['details'] 	= $row->email_message;
					$data['news']['sms'] = $row->sms;
					$data['news']['sms_text'] = $row->sms_text;
					if (isset($query)) $query->free_result();			
				}
				$data['heading'] = "Edit Email Template";
				$data['page'] 	 = 'edit';
				$this->load->vars($data);
				$this->load->view($this->container);

			}
		}else{
			redirect('login','location');			
		}
	}

		//delete News details
	function delete(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"DELETE")){
			$id = $this->uri->segment(3);
			$this->company_emailmodel->delete($id);
			if($this->db->affected_rows()=='1'){
				$this->session->set_flashdata('success','News information deleted successfully');
				redirect('company_email_template/listall/','location');
			}
		}else{		
			redirect('login','location');		
		}
	}

		//change status
	function changestatus(){
		if($this->session->userdata("clms_front_userid")==''){
			redirect('login','location');
		}else{		
			$id = $this->uri->segment(4);
			$status = $this->uri->segment(3);
			if($status =='1'){
				$value['details']['status'] = '0';
			}else{
				$value['details']['status'] = '1';
			}
			$this->session->set_flashdata('success','News Status Changed Successfully');
			$this->company_emailmodel->update($id,$value['details']);
			redirect('news/listall/','location');
		}
	}
	function cascadeAction() {
		$data = $_POST['object'];
		$ids = $data['ids'];
		$action = $data['action'];
		$query = $this->company_emailmodel->cascadeAction($ids, $action);
	}	
}
?>
