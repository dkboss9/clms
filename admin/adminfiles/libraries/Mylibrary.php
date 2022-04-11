<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class MyLibrary{



    function __construct(){

        $this->CI=& get_instance();

        $this->CI->load->helper('form');

        $this->CI->load->helper('url');

        $this->CI->load->model('commonmodel', 'commonmodel');

    }

	function getCompanyLogo($client_id){

		$query = $this->CI->commonmodel->getLogo($client_id);

		if($query->num_rows()>0){

			$row = $query->row();

			return $row->comp_logo;

		}else{

			return '';

		}

	}

	function getCompanyEmailTemplate($template_id,$company_id){

		$this->CI->db->where('email_id',$template_id);

		$this->CI->db->where('company_id',$company_id);

		$query = $this->CI->db->get('company_email_template');	

		return $query->row();

		$query->free_result();

	}

	

	function getsublinks($parent_id){

			$links = '';

			$user_id = $this->CI->session->userdata('userid');

			$gid = $this->CI->session->userdata('usergroup');

			$this->CI->db->where('menuid',$parent_id);

			$qmenu = $this->CI->db->get('admin_menu',1);

			$rmenu = $qmenu->row();

			if($gid!=1){

				$sql = "SELECT * FROM pnp_admin_menu m 

						WHERE fn_CheckMenuPermission(m.menuid,". $user_id .") = 1

						AND  parent_id='".$parent_id."' AND group_label='' 

						ORDER BY m.position"; 

				$query = $this->CI->db->query($sql);

				if($query->num_rows()>0){

					$links .= '<div class="panel panel-default sidebar">

							  <div class="panel-heading">'.$rmenu->menu_name.'</div>

							  <ul class="nav nav-stacked">';

					foreach($query->result() as $row):

						$links .= '<li>'.anchor($row->menu_link,$row->menu_name).'</li>';

					endforeach;

					$links .= '</ul>

							</div>';

				}

				$query->free_result();

				$qsub = "SELECT DISTINCT(group_label) AS group_label 

						FROM pnp_admin_menu m 

						WHERE parent_id='".$parent_id."' 

						AND group_label!='' 

						AND fn_CheckMenuPermission(m.menuid,". $user_id .") = 1

						ORDER BY m.position";

				$qgroup = $this->CI->db->query($qsub);

				if($qgroup->num_rows()>0){

					foreach($qgroup->result() as $rgroup):

						$links .= '<div class="panel panel-default sidebar">

								   <div class="panel-heading">'.$rgroup->group_label.'</div>

								   <ul class="nav nav-stacked">';

						 $sqlm = "SELECT * FROM pnp_admin_menu m 

								WHERE parent_id='".$parent_id."' 

								AND group_label='".$rgroup->group_label."' 

								AND fn_CheckMenuPermission(m.menuid,". $user_id .") = 1

								ORDER BY m.position";

						  $mquery = $this->CI->db->query($sqlm);

						  if($mquery->num_rows()>0){

							  foreach($mquery->result() as $rmenu):

								$links .= '<li>'.anchor($rmenu->menu_link,$rmenu->menu_name).'</li>';

							  endforeach;

						  }

						  $mquery->free_result();

						$links .= '</ul>

								</div>';	

					endforeach;	

				}

				

				

				$qgroup->free_result();

			}else{

				$sql = "SELECT * FROM pnp_admin_menu m WHERE  parent_id='".$parent_id."' AND group_label='' ORDER BY m.position"; 

				$query = $this->CI->db->query($sql);

				if($query->num_rows()>0){

					$links .= '<div class="panel panel-default sidebar">

							  <div class="panel-heading">'.$rmenu->menu_name.'</div>

							  <ul class="nav nav-stacked">';

					foreach($query->result() as $row):

						$links .= '<li>'.anchor($row->menu_link,$row->menu_name).'</li>';

					endforeach;

					$links .= '</ul>

							</div>';

				}

				$query->free_result();

	

				$qsub = "SELECT DISTINCT(group_label) as group_label FROM pnp_admin_menu m WHERE parent_id='".$parent_id."' AND group_label!='' ORDER BY m.position";

				$qgroup = $this->CI->db->query($qsub);

				if($qgroup->num_rows()>0){

					foreach($qgroup->result() as $rgroup):

						$links .= '<div class="panel panel-default sidebar">

								   <div class="panel-heading">'.$rgroup->group_label.'</div>

								   <ul class="nav nav-stacked">';

						 $sqlm = "SELECT * FROM pnp_admin_menu m WHERE parent_id='".$parent_id."' AND group_label='".$rgroup->group_label."' ORDER BY m.position";

						  $mquery = $this->CI->db->query($sqlm);

						  if($mquery->num_rows()>0){

							  foreach($mquery->result() as $rmenu):

								$links .= '<li>'.anchor($rmenu->menu_link,$rmenu->menu_name).'</li>';

							  endforeach;

						  }

						  $mquery->free_result();

						$links .= '</ul>

								</div>';	

					endforeach;	

				}

				$qgroup->free_result();

				$qmenu->free_result();

				

			}

			return $links;

		}

	

	function getPermissions($group_id){

		$permission = array();

		$this->CI->db->where('group_id',$group_id);

		$query = $this->CI->db->get('permissions_per_group');

		if($query->num_rows()>0){

			foreach($query->result() as $row):

				$permission[] = $row->module_id;

			endforeach;	

		}

		return $permission;

		$query->free_result();

	}

	

	function getMenuInformation(){

		if($this->CI->uri->segment(2)!=''){

			$link = $this->CI->uri->segment(1).'/'.$this->CI->uri->segment(2).'/';	

		}else{

			$link = $this->CI->uri->segment(1).'/';

		}

		$this->CI->db->where('menu_link',$link);

		$this->CI->db->where('parent_id !=','0');

		$query = $this->CI->db->get('admin_menu');

		if($query->num_rows()>0){

			$row = $query->row();

			return $row->description;	

		}else{

			return '';	

		}

		$query->free_result();

	}



	function getlogo(){

		$this->CI->db->where('config_id',24);

		$query = $this->CI->db->get('site_config');

		if($query->num_rows()>0){

			$row = $query->row();

			return '<img class="logo" src="'.$this->getSiteEmail(21).'uploads/logo/'.$row->config_value.'" alt="'.$this->getSiteEmail(20).'"  height="69">';;

		}else{

			return '<img class="logo" src="'.$this->getSiteEmail(21).'themes/images/icons/logo.png" alt="'.$this->getSiteEmail(20).'"  height="69">';	

		}

		$query->free_result();

	}

	function getSiteEmail($config_id){

		$this->CI->db->where('config_id',$config_id);

		$query = $this->CI->db->get('site_config');

		if($query->num_rows()>0){

			$row = $query->row();

			return $row->config_value;

		}else{

			return 'info@printnprint.com.au';	

		}

		$query->free_result();	

	}

	function getEmailTemplate($template_id){

		$this->CI->db->where('email_id',$template_id);

		$query = $this->CI->db->get('email_template');	

		return $query->row();

		$query->free_result();

	}

	

	function getCustomerDetails($order_id){

		$this->CI->db->select('c.customer_id,first_name,email as cust_email, last_name,company,orders_num,customer_type, order_status,payment_status');

		$this->CI->db->from('customers c');

		$this->CI->db->join('orders o','o.customer_id=c.customer_id');

		$this->CI->db->where('order_id',$order_id);

		$query = $this->CI->db->get();

		return $query->row();

		$query->free_result();

	}

	

	function getBillingDetails($order_id){

		$this->CI->db->select('bill_address,bill_suburb,bill_postal_code,s.state_id,state_code,bill_address2');

		$this->CI->db->from('order_delivery o');

		$this->CI->db->join('states s','s.state_id=o.bill_state');

		$this->CI->db->where('order_id',$order_id);

		$this->CI->db->limit(1);

		$query = $this->CI->db->get();	

		if($query->num_rows()>0){

			$row = $query->row();

			$address  ='';

			$address .= $row->bill_address.'__'.$row->bill_suburb.'__'.$row->state_code.'__'.$row->bill_postal_code.'__'.$row->bill_address2.'__'.$row->state_id;

			return $address;	

		}else{

			return '';	

		}

		$query->free_result();

	}

	

	function getDeliveryDetails($order_id){

		$this->CI->db->select('deliver_address,deliver_suburb,deliver_postal_code,s.state_id,state_code,deliver_address2, additional_info');

		$this->CI->db->from('order_delivery o');

		$this->CI->db->join('states s','s.state_id=o.deliver_state');

		$this->CI->db->where('order_id',$order_id);

		$this->CI->db->limit(1);

		$query = $this->CI->db->get();	

		if($query->num_rows()>0){

			$row = $query->row();

			$address  ='';

			$address .= $row->deliver_address.'__'.$row->deliver_suburb.'__'.$row->state_code.'__'.$row->deliver_postal_code.'__'.$row->deliver_address2.'__'.$row->state_id.'__'.$row->additional_info;

			return $address;	

		}else{

			return '';	

		}

		$query->free_result();	

	}

	

	function getDispatchMethod($order_id){

		$this->CI->db->select('od.*');

		$this->CI->db->from('order_dispatch od');

		$this->CI->db->join('orders o','o.order_id=od.order_id');

		$this->CI->db->where('od.order_id',$order_id);

		$this->CI->db->limit(1);

		$query = $this->CI->db->get();	

		if($query->num_rows()>0){

			return $query->row();

		}else{

			return '';	

		}

		$query->free_result();		

	}

	

	function getOrderDate($orderid){

		$this->CI->db->select('orders_date');

		$this->CI->db->where('order_id',$orderid);	

		$query = $this->CI->db->get('orders');

		if($query->num_rows()>0){

			$row = $query->row();

			return date('Y-m-d',strtotime($row->orders_date));

		}else{

			return '';	

		}

		$query->free_result();

	}

	function getOrderId($order_no){

		$this->CI->db->select('order_id');

		$this->CI->db->where('orders_num',$order_no);	

		$query = $this->CI->db->get('orders');

		if($query->num_rows()>0){

			$row = $query->row();

			return $row->order_no;

		}else{

			return '';	

		}

		$query->free_result();	

	}

	function getPaymentByOrder($order_id){

		$sql = "SELECT ifnull(sum(payment_amount),0) as total FROM pnp_order_payment WHERE order_id='".$order_id."'";

		$query = $this->CI->db->query($sql);

		if($query->num_rows()>0){

			$row = $query->row();

			return $row->total;

		}

		return 0;

	}

	

	function getAdminName($sales_representative_id){

		$this->CI->db->where('sales_representative_id',$sales_representative_id);

		$query = $this->CI->db->get('sales_representatives');

		$row = $query->row();

		return $row->sales_representative_name	;

	}

	function getCustomerDetailsForemail($customer_id){

		$this->CI->db->select('c.first_name,c.mobile,c.last_name,c.email as cust_email,u.email as sales_email,u.phone, sales_representative_name');

		$this->CI->db->from('customers c');

		$this->CI->db->join('sales_representatives s','s.sales_representative_id=c.sales_rep');

		$this->CI->db->join('users u','u.userid=s.user_id');

		$this->CI->db->where('customer_id',$customer_id);

		$query = $this->CI->db->get();

		return $query->row();

	}

	



}