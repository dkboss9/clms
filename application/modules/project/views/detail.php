<div class="row">
  <div class="col-md-12">
    <section class="panel">

      <div class="panel-body">



       <?php 
       $row = $this->projectmodel->project_listdetail($result->project_id);
       $assign = 0;
       $emps = $this->projectmodel->get_projectEmployee($result->project_id);
       if(count($emps) > 0)
        $assign = 1;
      $sups = $this->projectmodel->get_projectSupplier($result->project_id);
      if(count($sups) > 0)
        $assign = 1;
      ?>
      <div class="form-group">
        <label class="col-md-4 control-label" ><strong>Enrolment Number: </strong><?php echo $row->order_no;?></label>
        <label class="col-md-4 control-label" ><strong>Client: </strong> <?php echo $row->fname.' '.$row->lname;?></label>
        <label class="col-md-4 control-label" ><strong>Sales Rep: </strong> <?php echo $row->first_name.' '.$row->last_name;?></label>
      </div>

      <div class="form-group">
        <label class="col-md-4 control-label" ><strong>Grand Total: </strong><?php echo $row->grand_total;?> <?php echo $enroll->currency;?></label>
        <label class="col-md-4 control-label" ><strong>Commission Rate: </strong> <?php echo $row->commission_rate;?></label>
        <label class="col-md-4 control-label" ><strong>Commission: </strong> <?php echo $row->commission;?></label>
      </div>

      <div class="form-group">
        <label class="col-md-4 control-label" ><strong>Added Date: </strong><?php echo date("d/m/Y",$row->added_date);?></label>
        <label class="col-md-4 control-label" ><strong>Start Date: </strong> <?php echo date("d/m/Y",$row->start_date);?></label>
        <label class="col-md-4 control-label" ><strong>Deadline: </strong> <?php echo date("d/m/Y",$row->end_date);?></label>
      </div>

      <div class="form-group">
        <label class="col-md-4 control-label" ><strong>Lead Type: </strong><?php echo $row->type_name;?></label>
        <label class="col-md-4 control-label" ><strong>Is Assigned: </strong> <?php

         if($assign == 0){
          ?>
          <img src="<?php echo base_url("assets/images/notdone.png");?>">
          <?php
        }else{
          ?>
          <img src="<?php echo base_url("assets/images/done.png");?>">
          <?php
        }
        ?></label>
        <label class="col-md-4 control-label" ><strong>Status: </strong> <span class="label" style="color:#fff;background: <?php echo $row->code;?>"><?php echo $row->status_name;?></span></label>
      </div>
      <?php
      $intake = $this->intakemodel->getdata($row->intake)->row();
      $college = $this->collegemodel->getdata($row->college)->row();
      $degree = $this->degreemodel->getdata($row->degree)->row();
      $course = $this->coursemodel->getdata($row->course)->row();
      ?>

      <div class="form-group">
        <label class="col-md-4 control-label" ><strong>Intake: </strong><?php echo @$intake->type_name;?></label>
        <label class="col-md-4 control-label" ><strong>College </strong> <?php echo @$college->type_name;?></label>
        <label class="col-md-4 control-label" ><strong>Degree: </strong> <?php echo @$degree->type_name;?></label>
      </div>

      <div class="form-group">
        <label class="col-md-4 control-label" ><strong>Course: </strong><?php echo @$course->type_name;?></label>
      </div>


    </div>
  </section>
</div>
</div>


<div class="row">
  <div class="col-md-12">
    <section class="panel">
      <?php 
      $checklists = $this->appointmentmodel->listChecklist($enroll->fee_id);
      $downloads    = $this->appointmentmodel->listDownloadForm($enroll->fee_id);
      ?>
      <div class="panel-body">
        <a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo ($this->uri->segment(2) == 'checklist' || $this->uri->segment(2) == 'edit_checklist') ? 'btn-active' : 'btn-default';?>" href="<?php echo base_url("project/checklist/".$result->project_id);?>">Checklist (<?php echo $checklists->num_rows();?>)</a>
        <a class="mb-xs mt-xs mr-xs modal-basic btn  <?php echo ($this->uri->segment(2) == 'form_download') ? 'btn-active' : 'btn-default';?>" href="<?php echo base_url("project/form_download/".$result->project_id);?>">Form to download (<?php echo $downloads->num_rows();?>)</a>
        
      </div>
    </section>
  </div>
</div>