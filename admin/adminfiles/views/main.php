<?php
	$this->load->view('header');
	isset($page) ? $this->load->view($page) : null;
	$this->load->view('footer');
	
?> 

