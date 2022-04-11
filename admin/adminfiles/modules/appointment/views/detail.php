
<div id="custom-content" class="white-popup-block white-popup-block-md">
  <div class="row">
    <div class="col-md-12">
      <?php  //print_r($this->session->userdata);?>
      <h5><?php echo $result->lead_name;?></h5>
      <p><?php echo $result->company_name;?></p>
      <?php echo '<p> Query: '.$result->query.'</p>';?>
      <?php echo '<p> Requirement: '.$result->requirements.'</p>';?>
      <?php 
      $status = $this->dashboardmodel->get_leadstatus($result->status_id);
      if($result->status_id == 1)
        $class = 'label-warning';
      elseif($result->status_id == 4)
        $class = 'label-danger';
      else
        $class = 'label-success';
      ?>
      <p>Status: <span class="label <?php echo $class;?>"><?php echo @$status->status_name;?></span></p>
    </div>
  </div>
  <hr>
  <div class="row">

    <div class="col-md-12">
      <?php 
      $docs = $this->appointmentmodel->get_documents($result->lead_id);
      if(count($docs) >0){
        foreach ($docs as $doc) {
          echo '<p id="file_'.$doc->doc_id.'"><a href="'.SITE_URL.'uploads/leads/'.$doc->file_name.'" target="_blank">'.$doc->file_name.'</a> &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" rel="'.$doc->doc_id.'" class="link_delete"><span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a> </p>';
        }}else{
          echo "No Document added yet.";
        }
        ?>

      </div>
    </div>
    <?php 
    $updates = $this->appointmentmodel->get_updates($result->lead_id);
  //echo $this->db->last_query();
    foreach ($updates as $update) { ?>
    <hr>
    <div class="row">

      <div class="col-md-12">
        <?php echo '<h6>'.$update->content.'</h6>';?>
        <?php echo '<p> Added by : '.$update->first_name.' '.$update->last_name.' at '.date("d M Y",$update->added_date).'</p>';?>

      </div>
    </div>
    <?php } ?>
    <hr>

    <form method="post"  action="<?php echo base_url("appointment/add_update");?>">

      <div class="row">
        <div class="col-sm-12">
          <h3>Add Update</h3>
        </div>
      </div>
      <?php 
      if($result->reminder_date == '0')
        $remind_date = '';
      else
        $remind_date = date("d-m-Y",$result->reminder_date);
      ?>
      <div class="form-group">
        <label class="col-md-3 control-label">Reminder Date</label>
        <div class="col-md-9">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </span>
            <input type="text"  id="reminder_date" name="date" value="<?php echo $remind_date;?>" class="form-control datepicker">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">Reminder Time</label>
        <div class="col-md-9">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-clock-o"></i>
            </span>
            <input type="text" data-plugin-timepicker="" value="<?php echo $result->reminder_time;?>" name="time" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Sale Reps</label>
        <div class="col-md-9">
          <select name="user" class="form-control mb-md" <?php if($this->session->userdata("usergroup") != '1' && $this->session->userdata("usergroup") != '7')  echo 'disabled=""';?>>
            <option value="">Select</option>
            <?php 
            foreach($users as $user){
              ?>
              <option <?php if($result->user_id == $user->userid) echo 'selected="selected"';?>value="<?php echo $user->userid;?>"><?php echo $user->first_name.' '.$user->last_name;?></option>
              <?php
            }
            ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Weightage</label>
        <div class="col-md-9">
         <select name="weightage" class="form-control mb-md required">
          <option value="">Select</option>
          <?php 
          foreach($weightage as $row){
            ?>
            <option <?php if($result->weightage_id == $row->weightage_id) echo 'selected="selected"';?>value="<?php echo $row->weightage_id;?>"><?php echo $row->name;?></option>
            <?php
          }
          ?>
        </select>
      </div>
    </div>
 

  
    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Status</label>
      <div class="col-md-9">
       <select name="status" class="form-control mb-md">

         <option value="6">Counselling</option>
       </select>
     </div>
   </div>
   <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Remark</label>
    <div class="col-md-9">
      <textarea name="remark" class="form-control"><?php echo $result->remark;?></textarea>

    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Next Action</label>
    <div class="col-md-9">
      <textarea name="action" class="form-control"><?php echo $result->next_action;?></textarea>

    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Today's Update</label>
    <div class="col-md-9">
      <textarea name="details123"  class="form-control" rows="6" required></textarea>
    </div>
  </div>
  <div class="row mb-lg">
    <div class="col-sm-9 col-sm-offset-3">
      <input type="hidden" value="<?php echo $tab;?>" name="tab" >
      <input type="hidden" value="<?php echo $result->lead_id;?>" name="lead_id">
      <input type="hidden" value="<?php echo $this->input->get("project")??0;?>" name="project">
      <input type="submit" value="Submit" name="submit" class="btn btn-primary">
      <button type="reset" class="btn btn-default">Reset</button>
    </div>
  </div>

</form>

</div>


<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>
