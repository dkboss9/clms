

<style type="text/css">
.btn-action{
  padding: 5px;
  color: #fff !important;
}
</style>
<section class="panel">
  <div class="panel-body">
   <div class="summary">
    <div class="row">
      <div class="col-md-12 col-lg-4 col-xl-4">

        <div class="info">
          <strong>
            Name: <?php echo $result->first_name.' '.$result->last_name;?>
          </strong>
          <span class="text-primary">&nbsp;</span>
        </div>
      </div>

      <div class="col-md-12 col-lg-4 col-xl-4">

        <div class="info">
          <strong>
            Email: <?php echo $result->email;?>
          </strong>
          <span class="text-primary">&nbsp;</span>
        </div>
      </div>

      <div class="col-md-12 col-lg-4 col-xl-4">

        <div class="info">
          <strong>
            Phone: <?php echo $result->phone;?>
          </strong>
          <span class="text-primary">&nbsp;</span>
        </div>
      </div>


    </div>
    <div class="row" style="padding-top: 10px;">
     <?php
     foreach ($lead_types as $row) {
      $rate = $this->referal_model->get_referal_price($referral_id,$row->type_id);
      ?>
      <div class="col-md-12 col-lg-4 col-xl-4">

        <div class="info">
          <strong>
            <?php echo $row->type_name;?> Rate: <?php echo @$rate->rate;?>
          </strong> &nbsp; &nbsp;  &nbsp;  &nbsp;
          <span class="text-primary">  <input type="checkbox" name="is_percent[]" value="1" <?php echo  @$rate->is_percentage == 1 ? 'checked="checked"':'';?> class="is_percent" disabled="true" /> Is percentage</span>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>

</div>
</section>
<div class="row">
  <div class="col-md-12 col-lg-6 col-xl-6">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-secondary">
              <i class="glyphicon glyphicon-user" aria-hidden="true" data-original-title="" title=""></i>
            </div>
          </div>
          <?php 
          $customers   = $this->customermodel->listall(array('referral_id'=>$referral_id));
          ?>
          <div class="widget-summary-col">
            <div class="summary">
              <h3 class="title"><strong>Referral customer</strong></h3>

              <div class="info">
                <strong style="font-size: 24px;">
                 <a href="<?php echo base_url("dashboard/customer");?>"> <?php echo $customers->num_rows();?></a>
               </strong>
               <span class="text-primary">&nbsp;</span>
             </div>
           </div>

         </div>
       </div>
     </div>
   </section>
 </div>
 <div class="col-md-12 col-lg-6 col-xl-6">
  <section class="panel panel-featured-left panel-featured-secondary">
    <div class="panel-body">
      <div class="widget-summary">

       <div class="widget-summary-col widget-summary-col-icon">
        <div class="summary-icon bg-primary">
          <i class="glyphicon glyphicon-lock"></i>
        </div>
      </div>

      <?php 
      $requests = $this->referral_request_model->listall($referral_id);
      ?>

      <div class="widget-summary-col">
        <div class="summary">
          <h3 class="title"><strong>Referral Request</strong></h3>
          <div class="info">
            <strong style="font-size: 24px;">
              <a href="<?php echo base_url("dashboard/referrals");?>"> <?php echo $requests->num_rows();?> </a>
            </strong>
            <span class="text-primary">&nbsp;</span>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="col-md-12 col-lg-6 col-xl-6">
  <section class="panel panel-featured-left panel-featured-tertiary">
    <div class="panel-body">
      <div class="widget-summary">
        <div class="widget-summary-col widget-summary-col-icon">
          <div class="summary-icon bg-tertiary">
           <i class="fa fa-cubes"></i>
         </div>
       </div>
       <?php 
       $pending_requests = $this->referral_request_model->listall($referral_id,9);
       ?>

       <div class="widget-summary-col">
         <div class="summary">
          <h3 class="title"><strong>Pending Referral</strong></h3>
          <div class="info">
            <strong style="font-size: 24px;">
              <a href="<?php echo base_url("dashboard/referrals?status=9");?>">
                <?php echo $pending_requests->num_rows();?> 
              </a>
            </strong>
            <span class="text-primary">&nbsp;</span>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
</div>

<div class="col-md-12 col-lg-6 col-xl-6">
  <section class="panel panel-featured-left panel-featured-tertiary">
    <div class="panel-body">
      <div class="widget-summary">
        <div class="widget-summary-col widget-summary-col-icon">
          <div class="summary-icon bg-tertiary">
           <i class="fa fa-cubes"></i>
         </div>
       </div>
       <?php 
       $processing_requests = $this->referral_request_model->listall($referral_id,10);
       ?>
       <div class="widget-summary-col">
         <div class="summary">
           <h3 class="title"><strong> Processing Referral</strong></h3>
           <div class="info">
            <strong style="font-size: 24px;">
              <a href="<?php echo base_url("dashboard/referrals?status=10");?>">
                <?php echo $processing_requests->num_rows();?>
              </a>
            </strong>
            <span class="text-primary">&nbsp;</span>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
</div>


<div class="col-md-12 col-lg-6 col-xl-6">
  <section class="panel panel-featured-left panel-featured-tertiary">
    <div class="panel-body">
      <div class="widget-summary">
        <div class="widget-summary-col widget-summary-col-icon">
          <div class="summary-icon bg-tertiary">
           <i class="fa fa-cubes"></i>
         </div>
       </div>
       <?php 
       $referral_orders = $this->ordermodel->listall('','','','',$referral_id);
       ?>
       <div class="widget-summary-col">
         <div class="summary">
           <h3 class="title"><strong> Total Order</strong></h3>
           <div class="info">
            <strong style="font-size: 24px;">
              <a href="<?php echo base_url("dashboard/order?referral_id=".$this->session->userdata("clms_front_userid"));?>">
                <?php echo $referral_orders->num_rows();?>
              </a>
            </strong>
            <span class="text-primary">&nbsp;</span>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
</div>

<div class="col-md-12 col-lg-6 col-xl-6">
  <section class="panel panel-featured-left panel-featured-tertiary">
    <div class="panel-body">
      <div class="widget-summary">
        <div class="widget-summary-col widget-summary-col-icon">
          <div class="summary-icon bg-tertiary">
           <i class="fa fa-dollar"></i>
         </div>
       </div>
       <?php 
       $earning = $this->ordermodel->total_earning($referral_id);
       ?>
       <div class="widget-summary-col">
         <div class="summary">
           <h3 class="title"><strong> Total Earning</strong></h3>
           <div class="info">
            <strong style="font-size: 24px;">
              <a href="<?php echo base_url("dashboard/referrals?status=10");?>">
                <?php echo $earning->earning;?>
              </a>
            </strong>
            <span class="text-primary">&nbsp;</span>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
</div>

</div>



</section>
