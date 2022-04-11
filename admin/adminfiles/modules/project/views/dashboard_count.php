<?php 


 $appointment_num1 = $this->appointmentmodel->listall(null,null,null,null,null,null,null,'today',null,1,$student_id)->num_rows();
 $appointment_num2 = $this->appointmentmodel->listall(null,null,null,null,null,null,null,'tomorrow',null,1,$student_id)->num_rows();

 $enroll1 = $this->projectmodel->listall('next_month',null,null,null,null,null,null,null,null,null,$student_id)->num_rows();
 $enroll2 = $this->projectmodel->listall('month',null,null,null,null,null,null,null,null,null,$student_id)->num_rows();
 $enroll3 = $this->projectmodel->listall('today',null,null,null,null,null,null,null,null,null,$student_id)->num_rows();

 $invoice_num1 = $this->dashboardmodel->countInvoice('1',$student_id);
 
 $invoice_num2 = $this->dashboardmodel->countInvoice('2',$student_id);
 
 $invoice_num3 = $this->dashboardmodel->countInvoice(null,$student_id);

?>
<div class="row">

  <div class="col-md-12 col-lg-4 col-xl-4 lead_count_wrapper">
    <div class="lead_count_header">
      <div class=" appointment_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
      <div class="lead_title">Appointments</div>
      <div class=" appointment_icon"> <a href="<?php echo base_url("project/appointments/$student_id");?>">View All</a></div>
    </div>
    <div class="lead_count_body">
      <div class="counter_wrapper">
        <div class="counter_title">Today </div>
        <div class="counter">
          <a href="<?php echo base_url("project/appointments/$student_id?appointment_date=today");?>"><?php echo $appointment_num1;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title">Tomorrow </div>
        <div class="counter">
          <a href="<?php echo base_url("project/appointments/$student_id?appointment_date=tomorrow");?>"><?php echo $appointment_num2;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title"> Total </div>
        <div class="counter">
          <a href="<?php echo base_url("project/appointments/$student_id");?>"><?php echo $appointment_num1 + $appointment_num2;?></a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-lg-4 col-xl-4 lead_count_wrapper">
    <div class="lead_count_header">
      <div class="enroll_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
      <div class="lead_title"> Cases</div>
      <div class="enroll_icon"> <a href="<?php echo base_url("project/cases/$student_id");?>">View All</a></div>
    </div>
    <div class="lead_count_body">
      <div class="counter_wrapper">
        <div class="counter_title">Comming Month</div>
        <div class="counter">
          <a href="<?php echo base_url("project/cases/$student_id?commenced_date=next_month");?>"><?php echo $enroll1;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title">This Month</div>
        <div class="counter">
          <a href="<?php echo base_url("project/cases/$student_id?commenced_date=month");?>"><?php echo $enroll2;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title"> Today </div>
        <div class="counter">
          <a href="<?php echo base_url("project/cases/$student_id?commenced_date=today");?>"><?php echo $enroll3;?></a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-lg-4 col-xl-4 lead_count_wrapper">
    <div class="lead_count_header">
      <div class="invoice_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
      <div class="lead_title">Invoice</div>
      <div class="invoice_icon"> <a href="<?php echo base_url("project/invoice/$student_id");?>">View All</a></div>
    </div>
    <div class="lead_count_body">
      <div class="counter_wrapper">
        <div class="counter_title">Pending</div>
        <div class="counter">
          <a href="<?php echo base_url("project/invoice/$student_id?status=1");?>"><?php echo $invoice_num1;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title">Over Due</div>
        <div class="counter">
          <a href="<?php echo base_url("project/invoice/$student_id?status=2");?>"><?php echo $invoice_num2;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title"> Total</div>
        <div class="counter">
          <a href="<?php echo base_url("project/invoice/$student_id");?>"><?php echo $invoice_num3;?></a>
        </div>
      </div>
    </div>
  </div>
</div>