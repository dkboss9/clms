<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
//$this->load->view('common/header');
if($this->home_model->check_device()){
	if(isset($detail_header))
		$header1 = 'common/header-mobile-detail';
	elseif(isset($preview_header))
		$header1 = 'common/header-mobile-preview';
	else
		$header1 = 'common/header_mobile';
	}else{
		$header1 = 'common/header';
	}
//echo $header1; die();
	isset($header) ? $this->load->view($header) : $this->load->view($header1);
	isset($page) ? $this->load->view($page) : null;
//$this->load->view('common/footer');
	isset($footer) ? $this->load->view($footer) : $this->load->view('common/footer');

	?> 
