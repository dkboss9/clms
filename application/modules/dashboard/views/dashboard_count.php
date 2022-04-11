<?php 
 $num1 = $this->lmsmodel->fullowup('today')->num_rows();
 $num2 = $this->lmsmodel->fullowup('tomorrow')->num_rows();
 $num3 = $this->lmsmodel->fullowup('exceeded')->num_rows();

 $appointment_num1 = $this->lmsmodel->appointment('today')->num_rows();
 $appointment_num2 = $this->lmsmodel->appointment('tomorrow')->num_rows();

 $enroll1 = $this->dashboardmodel->getEnroll('next_month')->num_rows();
 $enroll2 = $this->dashboardmodel->getEnroll('month')->num_rows();
 $enroll3 = $this->dashboardmodel->getEnroll('today')->num_rows();

 $invoice_num1 = $this->dashboardmodel->countInvoice('1');
 $invoice_num2 = $this->dashboardmodel->countInvoice('2');
 $invoice_num3 = $this->dashboardmodel->countInvoice();

?>
<div class="row">
  <div class="col-md-12 col-lg-3 col-xl-3 lead_count_wrapper">
    <div class="lead_count_header">
      <div class="lead_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
      <div class="lead_title">Leads</div>
      <div class="lead_icon"> <a href="<?php echo base_url("dashboard/leads");?>">View All</a></div>
    </div>
    <div class="lead_count_body">
      <div class="counter_wrapper">
        <div class="counter_title">Today Followup</div>
        <div class="counter">
          <a href="<?php echo base_url("dashboard/leads?lead_date=today");?>"><?php echo $num1;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title">Tomorrow Followup</div>
        <div class="counter">
          <a href="<?php echo base_url("dashboard/leads?lead_date=tomorrow");?>"><?php echo $num2;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title"> Deadline Exceeded</div>
        <div class="counter">
          <a href="<?php echo base_url("dashboard/leads?lead_date=exceeded");?>"><?php echo $num3;?></a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-lg-3 col-xl-3 lead_count_wrapper">
    <div class="lead_count_header">
      <div class=" appointment_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
      <div class="lead_title">Cases Lodged</div>
      <div class=" appointment_icon"> <a href="<?php echo base_url("dashboard/appointment");?>">View All</a></div>
    </div>
    <div class="lead_count_body">
      <div class="counter_wrapper">
        <div class="counter_title">Today </div>
        <div class="counter">
          <a href="<?php echo base_url("dashboard/appointment?appointment_date=today");?>"><?php echo $appointment_num1;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title">Tomorrow </div>
        <div class="counter">
          <a href="<?php echo base_url("dashboard/appointment?appointment_date=today");?>"><?php echo $appointment_num2;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title"> Total </div>
        <div class="counter">
          <a href="<?php echo base_url("dashboard/appointment");?>"><?php echo $appointment_num1 + $appointment_num2;?></a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-lg-3 col-xl-3 lead_count_wrapper">
    <div class="lead_count_header">
      <div class="enroll_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
      <div class="lead_title"> Enrolments</div>
      <div class="enroll_icon"> <a href="<?php echo base_url("dashboard/enroll");?>">View All</a></div>
    </div>
    <div class="lead_count_body">
      <div class="counter_wrapper">
        <div class="counter_title">Comming Month</div>
        <div class="counter">
          <a href="<?php echo base_url("dashboard/enroll?commenced_date=next_month");?>"><?php echo $enroll1;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title">This Month</div>
        <div class="counter">
          <a href="<?php echo base_url("dashboard/enroll?commenced_date=month");?>"><?php echo $enroll2;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title"> Today </div>
        <div class="counter">
          <a href="<?php echo base_url("dashboardenroll?commenced_date=today");?>"><?php echo $enroll3;?></a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-lg-3 col-xl-3 lead_count_wrapper">
    <div class="lead_count_header">
      <div class="invoice_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
      <div class="lead_title">Invoice</div>
      <div class="invoice_icon"> <a href="<?php echo base_url("dashboard");?>">View All</a></div>
    </div>
    <div class="lead_count_body">
      <div class="counter_wrapper">
        <div class="counter_title">Pending</div>
        <div class="counter">
          <a href="<?php echo base_url("invoice/listall?status=1");?>"><?php echo $invoice_num1;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title">Over Due</div>
        <div class="counter">
          <a href="<?php echo base_url("invoice/listall?status=2");?>"><?php echo $invoice_num2;?></a>
        </div>
      </div>
      <div class="counter_wrapper">
        <div class="counter_title"> Total</div>
        <div class="counter">
          <a href="<?php echo base_url("invoice/listall");?>"><?php echo $invoice_num3;?></a>
        </div>
      </div>
    </div>
  </div>
</div>



          <?php /*
<div class="row">
 
  <div class="col-md-12 col-lg-4 col-xl-4">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-primary">
              <i class="fa fa-life-ring"></i>
            </div>
          </div>
          <?php
        $referre = $this->dashboardmodel->getTopReferre();
        $college = $this->dashboardmodel->getTopcollege();
        $consultant = $this->dashboardmodel->getTopConsultant();
      //  print_r($consultant);
        ?>
          <div class="widget-summary-col">
            <div class="summary">
              <h3 class="title"><strong>This Month</strong></h3>
              <div class="info">
                Top Referee
                <span
                  class="text-primary"><?php echo @$referre->first_name.' '.@$referre->last_name;?>(<?php echo @$referre->num;?>)</span>
              </div>
              <div class="info">
                Top College
                <span class="text-primary"><?php echo @$college->type_name;?>(<?php echo @$college->num;?>)</span>
              </div>
              <div class="info">
                Top Consultant
                <span
                  class="text-primary"><?php echo @$consultant->first_name.' '.@$consultant->last_name;?>(<?php echo @$consultant->num;?>)</span>
              </div>
            </div>
            <div class="summary-footer">
              <a class="text-muted text-uppercase">(view all)</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-md-12 col-lg-4 col-xl-4">
    <section class="panel panel-featured-left panel-featured-secondary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-secondary">
              <i class="glyphicon glyphicon-lock"></i>
            </div>
          </div>

          <div class="widget-summary-col">
            <div class="summary">
              <h3 class="title"><strong>Leads</strong></h3>
              <?php
          $num = $this->lmsmodel->listall($handle='',$country='',$weightage='',$status='',$category='',$access='',$language='',$lead_date='',$added_date='');
          ?>
              <div class="info">
                Total
                <span class="text-primary"><a
                    href="<?php echo base_url("dashboard");?>">(<?php echo $num->num_rows;?>)</a></span>
              </div>
              <?php
          $num = $this->lmsmodel->listall($handle='',$country='',$weightage='',$status='3',$category='',$access='',$language='',$lead_date='',$added_date='');
          ?>
              <div class="info">
                Wins
                <span class="text-primary"><a
                    href="<?php echo base_url("dashboard?status=3");?>">(<?php echo $num->num_rows;?>)</a></span>
              </div>
              <?php
          $num = $this->lmsmodel->listall($handle='',$country='',$weightage='',$status='4',$category='',$access='',$language='',$lead_date='',$added_date='');
          ?>
              <div class="info">
                Losses
                <span class="text-primary"><a
                    href="<?php echo base_url("dashboard?status=3");?>">(<?php echo $num->num_rows;?>)</a></span>
              </div>
            </div>
            <div class="summary-footer">
              <a href="<?php echo base_url("dashboard");?>" class="text-muted text-uppercase">(View all)</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
*/ ?>

<?php
/*
if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") > 0){ 
  $this->load->model("company/companymodel");
  $company_id = $this->session->userdata("clms_front_companyid");
  $company = $this->companymodel->getdata($company_id)->row();
  ?>

<div class="row">
  <div class="col-md-12 col-lg-4 col-xl-4">
    <section class="panel panel-featured-left panel-featured-quartenary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-quartenary">
              <i class="fa fa-usd"></i>
            </div>
          </div>
          <div class="widget-summary-col">
            <div class="summary">
              <h3 class="title"><strong>Enquiry Credits</strong>: <?php echo $company->enquiry_credit;?></h3>
              <h3 class="title"><strong>Sms Credits</strong>: <?php echo $company->sms_credit;?></h3>

            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-md-12 col-lg-4 col-xl-4">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-primary">
              <i class="fa fa-life-ring"></i>
            </div>
          </div>
          <div class="widget-summary-col">
            <div class="summary">
              <h3 class="title"><strong>Enquiry Used</strong>:
                <?php echo $company->enquiry_credit-$company->balance_enquiry;?></h3>
              <h3 class="title"><strong>Sms Used</strong>: <?php echo $company->sms_credit-$company->balance_sms;?></h3>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-md-12 col-lg-4 col-xl-4">
    <section class="panel panel-featured-left panel-featured-secondary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-secondary">
              <i class="glyphicon glyphicon-lock"></i>
            </div>
          </div>

          <div class="widget-summary-col">
            <div class="summary">
              <h3 class="title"><strong>Enquiry Balance</strong>: <?php echo $company->balance_enquiry;?></h3>
              <h3 class="title"><strong>Sms Balance</strong>: <?php echo $company->balance_sms;?></h3>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<?php 

} */
?>