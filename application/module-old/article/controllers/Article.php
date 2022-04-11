<?php
class Article extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->container = 'main';
		$this->load->model('articlemodel');
		$this->load->model('users/usermodel');
		$this->module_code = 'MANAGE-CONTENTS';
	}
	function index(){
		if($this->session->userdata("clms_front_userid")=='' && $this->usermodel->checkperm($this->module_code,"VIEW")){
			redirect('login','location');
		}else{		
			$this->manage();
		}
	}

		//display all gallery
	function manage(){
		if($this->session->userdata("clms_front_userid")!='' && $this->usermodel->checkperm($this->module_code,"VIEW")){
			$config['base_url'] 		= base_url().'index.php/article/manage';
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
			$query = $this->articlemodel->listall();
			$config['total_rows'] = $query->num_rows();
			$this->pagination->initialize($config);
			$query->free_result();
			$page = $this->uri->segment(3,0);			
			$limit = array("start"=>$config['per_page'],"end"=>$page);
			$query = $this->articlemodel->listall($limit);
			if($query->num_rows()>0){
				$i = 1;
				foreach($query->result() as $row){
					$data['article'][$i]['articleid'] 	= $row->articleid;
					$data['article'][$i]['title'] 		= $row->article_title;
					$data['article'][$i]['sn'] 			= $i;
					$data['article'][$i]['added_date'] 	= $row->publish_date;
					$data['article'][$i]['status'] 		= $row->status;
					$data['article'][$i]['publish'] 	=($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
					$i++;
				}
			}else{
				$data['norecord'] = "<strong>Static page(s) not created. ".anchor('article/add','Create new',array('class'=>'btn btn-primary'))."</strong>";
			}
			$data['heading'] = "Manage Static Page";
			$initial = ($page + 1) > $config['total_rows'] ? $config['total_rows'] : ($page + 1);
			$final = ($page + $config['per_page']);
			$string = $initial . " - " . (($config['total_rows'] > $final) ? $final : $config['total_rows']) . " of " . $config['total_rows'];				
			$data['pagenumbers'] 	= $string;
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
			if(isset($_REQUEST['submit'])){
				$details['article']['alias'] 			= str_replace('_','-',url_title($this->input->post('title'),'_',TRUE));
				$details['article']['position'] 		= $this->input->post('position');
				$details['article']['article_title'] 	= $this->input->post('title');
				$details['article']['site_title'] 	= $this->input->post('site_title');
				$details['article']['meta_keywords'] 	= $this->input->post('keywords');
				$details['article']['meta_description'] = $this->input->post('meta_desc');
				$details['article']['article_details'] 	= $this->input->post('pagedetails');
				$details['article']['page_type'] 		= $this->input->post('page_type');
				$details['article']['parent_id'] 		= $this->input->post('parent_id');
				$details['article']['publish_date'] 	= date('Y-m-d');
				$details['article']['status'] 		= 1;
				$this->articlemodel->insert($details['article']);
				$this->session->set_flashdata('success','Static page added successfully');
				redirect('article/manage/','location');
			}else{		
				$data['heading'] = "Add Static Page";
				$data['page'] = 'add';
				$this->load->vars($data);
				$this->load->view($this->container);
			}
		}else{
			redirect('login','location');
		}
	}
		//Update Page Details
	function edit(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"EDIT")){
			if(isset($_REQUEST['submit'])){
				$id = $this->input->post('articleid');
				$details['article']['position'] 		= $this->input->post('position');
				$details['article']['alias'] 			= str_replace('_','-',url_title($this->input->post('title'),'_',TRUE));
				$details['article']['article_title'] 	= $this->input->post('title');
				$details['article']['site_title'] 	= $this->input->post('site_title');
				$details['article']['meta_keywords'] 	= $this->input->post('keywords');
				$details['article']['meta_description'] = $this->input->post('meta_desc');
				$details['article']['article_details'] 	= $this->input->post('pagedetails');
				$details['article']['page_type'] 		= $this->input->post('page_type');
				$details['article']['parent_id'] 		= $this->input->post('parent_id');
				$this->articlemodel->update($id,$details['article']);
				$this->session->set_flashdata('success','Static page updated successfully');
				redirect('article/manage','location');
			}else{
				$id = $this->uri->segment(3);
				$query = $this->articlemodel->loadpage($id);
				if($query->num_rows()==1){
					$row = $query->row();
					$data['articleid'] 	= $row->articleid;
					$data['parent'] 	= $row->parent_id;
					$data['position'] 	= $row->position;
					$data['title'] 		= $row->article_title;
					$data['site_title'] = $row->site_title;
					$data['keywords'] 	= $row->meta_keywords;
					$data['description']= $row->meta_description;
					$data['details'] 	= $row->article_details;
					$data['type'] 		= $row->page_type;
					if (isset($query)) $query->free_result();			
				}
				$data['heading'] = "Edit Static Page";
				$data['page'] = 'article/edit';
				$this->load->vars($data);
				$this->load->view($this->container);

			}
		}else{
			redirect('login','location');			
		}
	}

		//delete page details
	function delete(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"DELETE")){
			$id = $this->uri->segment(3);
			$this->articlemodel->delete($id);
			$this->session->set_flashdata('success','Static page deleted successfully');
			if($this->db->affected_rows()=='1'){
				redirect('article/manage','location');
			}
		}else{		
			redirect('login','location');		
		}
	}
}
?>
