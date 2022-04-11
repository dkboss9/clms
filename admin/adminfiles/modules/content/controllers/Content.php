<?php
class Content extends MX_Controller{
	function __construct(){
		parent::__construct();
		$this->container = 'main';
		$this->load->model('contentmodel');
	}
	function index(){
		if($this->session->userdata("clms_userid")!=""){
			$this->listall();	
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}
	}

	

	function add(){
		if($this->session->userdata("clms_userid")!=""){
			if(isset($_REQUEST['save']) || isset($_REQUEST['submit'])){
				$this->form_validation->set_rules('cat_title','title','required');
				if($this->form_validation->run()==FALSE){
					$this->session->set_flashdata('error','Required fields missing');
					redirect('slider/add','location');
				}else{

					$value['details']['title'] 		= $this->input->post('cat_title');
					$value['details']['content'] 		= $this->input->post("content");
					$value['details']['status'] 		= '1';
					
					$this->contentmodel->insertdata($value['details']);
					$this->session->set_flashdata('success','Login content added successfully');
					if(isset($_REQUEST['save'])){
						redirect('content/add','location');
					}else{
						redirect('content/listall','location');
					}
				}
			}else{
				$data['page'] = 'content/add';
				$data['heading'] = 'Add Login content';
				$this->load->vars($data);
				$this->load->view($this->container);
			}
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}
	}

		//edit user details
	function edit(){
		if($this->session->userdata("clms_userid")!=""){
			if(isset($_REQUEST['submit'])){
				$catid	= $this->input->post('catid');
				$this->form_validation->set_rules('slider_title','Slider title','required');
				if($this->form_validation->run()==FALSE){
					$this->session->set_flashdata('error','Required fields missing');
					redirect('content/edit'.'/'.$catid,'location');
				}else{

					

					$value['details']['title'] 		= $this->input->post('slider_title');
					$value['details']['content'] 		= $this->input->post('content');
					$value['details']['status'] = $this->input->post("slider_status");
					
					$this->contentmodel->updatedata($value['details'],$catid);
					$this->session->set_flashdata('success','Login content updated successfully');
					redirect('content/listall','location');
				}
			}else{
				$catid = $this->uri->segment(3);
				$query = $this->contentmodel->getdata($catid);
				if($query->num_rows()>0){
					//$row = $query->row();
					$data['slider']	= $query->row();	
					$query->free_result();
					$data['page'] = 'edit';
					$data['heading'] = 'Edit Slider';
					$this->load->vars($data);
					$this->load->view($this->container);			
				}else{
					redirect('slider/listall','location');	
				}
			}
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}		
	}
	function delete(){
		if($this->session->userdata("clms_userid")!=""){
			$sliderid = $this->uri->segment(3);
			$this->contentmodel->deletedata($sliderid);
			$this->session->set_flashdata('success','Login content deleted successfully');
			redirect('content/listall','location');
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}
	}

		//list all district
	function listall(){
		if($this->session->userdata("clms_userid")!=""){
			$config['base_url'] = base_url().'slider/listall/';
			$config['uri_segment'] = 3;
			$config['per_page'] = 20;
			$config['cur_tag_open'] = '<li class="current">';
			$config['cur_tag_close'] = '</li>';
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			$config['next_link'] = '&raquo;';
			$config['prev_link'] = '&laquo;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$query = $this->contentmodel->listall();
			$config['total_rows'] = $query->num_rows();
			$this->pagination->initialize($config);
			$query->free_result();
			$page = $this->uri->segment(3,0);			
			$limit = array("start"=>$config['per_page'],"end"=>$page);
			
			$data["contents"]=$this->contentmodel->listall($limit);
			$data['pagination'] = $this->pagination->create_links();
			$data['page'] = 'list';
			$data['heading'] = 'Manage Login content';
			$this->load->vars($data);
			$this->load->view($this->container);
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}
	}

	function cascadeAction() {
		$data = $_POST['object'];
		$ids = $data['ids'];
		$action = $data['action'];
		$query = $this->slidermodel->cascadeAction($ids, $action);
		$this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
		echo '';
		exit();
	}
		//activate and deactivate category
	function publish(){
		if($this->session->userdata("clms_userid")!=""){
			$status 	= $this->uri->segment(3);
			$catid 		= $this->uri->segment(4);
			if($status==1){
				$value['details']['status'] = 0;
				$this->session->set_flashdata('success','Slider Image unpublished successfully');
			}else{
				$value['details']['status'] = 1;
				$this->session->set_flashdata('success','Slider Image published successfully');
			}
			$this->slidermodel->updatedata($value['details'],$catid);

			redirect('slider/manage','location');
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}
	}
}
?>
