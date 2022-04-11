

<?php 
if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
  ?>
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>We must tell you! </strong> Please select company to add this data.
  </div>
  <?php
}
?>

<div class="row">
  <div class="col-xs-12">
    <section class="panel form-wizard" id="w4">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle=""></a>
          <a href="#" class="" data-panel-dismiss=""></a>
        </div>

        <h2 class="panel-title">Contractor : [Add]</h2>
      </header>
      <div class="panel-body">
        <div class="wizard-progress wizard-progress-lg">
          <div class="steps-progress">
            <div class="progress-indicator" style="width: 0%;"></div>
          </div>
          <ul class="wizard-steps">
            <li class="active">
              <a href="#w4-account" data-toggle="tab"><span>1</span>Account Info</a>
            </li>
            <li>
              <a href="#w4-profile" data-toggle="tab"><span>2</span>Profile Info</a>
            </li>
            <li>
              <a href="#w4-billing" data-toggle="tab"><span>3</span>Availability</a>
            </li>

          </ul>
        </div>
        <form id="form" method="post" action="<?php echo base_url("supplier/add");?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
          <div class="tab-content">
            <div id="w4-account" class="tab-pane active">

             <div class="form-group">
              <label class="col-md-2 control-label" for="fname">First Name</label>
              <div class="col-md-3">
                <input type="text" name="fname" id="fname" value="<?php echo set_value("fname");?>" class="form-control" required  />
                <input type="hidden" name="role" id="role" value="3">
              </div>
              <label class="col-md-3 control-label" for="lname">Last Name</label>
              <div class="col-md-3">
                <input type="text" name="lname" id="lname" value="<?php echo set_value("lname");?>" class="form-control"  required/>
              </div>
            </div>

          

          <div class="form-group">
            <label class="col-md-2 control-label" for="email">Email</label>
            <div class="col-md-3">
             <input type="email" name="email" id="email" value="<?php echo set_value("email");?>" class="form-control" required />
             <?php echo form_error("email");?>
           </div>
           <label class="col-md-3 control-label">Image</label>
            <div class="col-md-3">
            <input type="file" name="logo" id="logo"  class="form-control"  accept="image/*"/>
          </div>
         </div>

   <div class="form-group">
 
   <label class="col-md-2 control-label" for="phone">Mobile</label>
   <div class="col-md-3">
     <input type="text" name="phone" id="phone" value="<?php echo set_value("phone");?>" class="form-control" required />
   </div>
 </div>


</div>
<div id="w4-profile" class="tab-pane">
 <div class="form-group">
   <label class="col-md-2 control-label" for="company">Company</label>
   <div class="col-md-3">
    <input type="text" name="company" id="company" value="<?php echo set_value("company");?>" class="form-control"  />
  </div>
  <label class="col-md-3 control-label" for="abn">ABN</label>
  <div class="col-md-3">
    <input type="text" name="abn" id="abn" value="<?php echo set_value("abn");?>" class="form-control"  />
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="level">Level of competency </label>
  <div class="col-md-3">
    <select name="level" id="level"  class="form-control">
      <option value="">Select</option>
      <?php 
      foreach($levels as $row){
        ?>
        <option value="<?php echo $row->level_id;?>" <?php echo $row->level_id == set_value("level")?"selected":'';?>><?php echo $row->level_title;?></option>
        <?php
      }
      ?>
    </select>
  </div>
  <label class="col-md-3 control-label" for="suburb">Suburb</label>
  <div class="col-md-3">
    <input type="text" name="suburb" id="suburb" value="<?php echo set_value("suburb");?>" class="form-control" required />
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="transport">Transport</label>
  <div class="col-md-3">
    <select name="transport" id="transport"  class="form-control">
      <option value="">Select</option>
      <?php 
      foreach($transports as $row){
        ?>
        <option value="<?php echo $row->transport_id;?>" <?php echo $row->transport_id == set_value("transport")?"selected":'';?>><?php echo $row->transport_title;?></option>
        <?php
      }
      ?>
    </select>
  </div>
  <label class="col-md-3 control-label" for="comment">Comment</label>
  <div class="col-md-3">
    <textarea name="comment" id="comment" class="form-control"><?php echo set_value("comment");?></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="position">Position</label>
  <div class="col-md-3">
   <select name="position" id="position"  class="form-control">
    <option value="">Select</option>
    <?php 
    foreach($positions as $row){
      ?>
      <option value="<?php echo $row->position_id;?>" <?php echo $row->position_id == set_value("position")?"selected":'';?>><?php echo $row->position_title;?></option>
      <?php
    }
    ?>
  </select>
</div>
<label class="col-md-3 control-label" for="wage">Wage</label>
  <div class="col-md-1">
    <input type="text" name="wage" id="wage"  class="form-control" value="<?php echo set_value("wage");?>"  required />
  </div>
  <div class="col-md-2">
   <select name="type" id="type"  class="form-control" required>
    <option value="">Select</option>
    <?php 
    foreach($types as $row){
      ?>
      <option value="<?php echo $row->type_id;?>" <?php echo $row->type_id == set_value("type")?"selected":'';?>><?php echo $row->type_title;?></option>
      <?php
    }
    ?>
  </select>
</div>
</div>


<div class="form-group">
  <label class="col-md-2 control-label" for="fual">Fual Allowance</label>
  <div class="col-md-3">
    <input type="text" name="fual" id="fual"  class="form-control" value="<?php echo set_value("fual");?>" />
  </div>
  <label class="col-md-3 control-label" for="productivity">Productivity  Allowance</label>
  <div class="col-md-3">
    <input type="text" name="productivity" id="productivity"  class="form-control" value="<?php echo set_value("productivity");?>" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="total">Total  Allowance</label>
  <div class="col-md-3">
    <input type="text" name="total" id="total"  class="form-control" value="<?php echo set_value("total");?>" />
  </div>
</div>

</div>
<div id="w4-billing" class="tab-pane">
  <?php
  $dbstart_time = set_value("start_time[]");
  $dbend_time = set_value("end_time[]");
  foreach($days as $day){
    $times = $this->companymodel->get_service_time($company_id,$day->day_id);
    if($times){
      $start = date('H:i',strtotime(@$times->service_start_time));
      $end =  date('H:i',strtotime(@$times->service_end_time));
    }
    ?>
                    <input type="hidden" name="day_id[]" value="<?php echo $day->day_id;?>">
                    <div class="form-group">
                        <label class="col-md-3 control-label"
                            for="productivity"><?php echo $day->day_name; ?></label>
                        <div class="col-md-3">
                            <select name="start_time[]" id="start_time<?php echo $day->day_id;?>"
                                class="form-control">

                                <?php  for ($i=0;$i<=23;$i++){
          for ($j=0;$j<=45;$j=$j+15)
          {
            $time_interval = $i.':'.str_pad($j, 2, '0', STR_PAD_LEFT);
            $time_interval = date('H:i',strtotime($time_interval));
            ?>
                                <option value="<?php echo $time_interval;?>"
                                    <?php if(@$start == $time_interval) echo 'selected="selected"'; ?>>
                                    <?php echo $time_interval;?></option>
                                <?php
          }
        }?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="end_time[]" id="end_time<?php echo $day->day_id;?>" class="form-control">

                                <?php  for ($i=0;$i<=23;$i++){
          for ($j=0;$j<=45;$j=$j+15)
          {
            $time_interval = $i.':'.str_pad($j, 2, '0', STR_PAD_LEFT);
            $time_interval = date('H:i',strtotime($time_interval));
            ?>
                                <option value="<?php echo $time_interval;?>"
                                    <?php if(@$end == $time_interval) echo 'selected="selected"'; ?>>
                                    <?php echo $time_interval;?></option>
                                <?php
          }
        }?>
                            </select>
                        </div>
                        <label class="col-md-3 control-label" id="err_serivce<?php echo $day->day_id;?>"></label>
                    </div>
                    <?php } ?>
</div>

</div>
</form>
</div>
<div class="panel-footer">
  <ul class="pager">
    <li class="previous disabled">
      <a><i class="fa fa-angle-left"></i> Previous</a>
    </li>
    <li class="finish hidden pull-right">
      <a id="link_finish">Finish</a>
    </li>
    <li class="next">
      <a>Next <i class="fa fa-angle-right"></i></a>
    </li>
  </ul>
</div>
</section>
</div>
</div>

<!-- end: page -->
</section>
</div>
</section>
<script type="text/javascript">
  $(document).ready(function(){
    $("#link_finish").click(function(){ 
      var cond = 1;
      for(var i=1;i<=7;i++){ 
        var start_time = $("#start_time"+i).val();
        var end_time = $("#end_time"+i).val();

        if((start_time != 0 && end_time == 0) || (start_time == 0 && end_time != 0) ){

          $("#err_serivce"+i).html("Both field are required.");
          cond = 0;
        }
      }

      if(cond == 0)
        return false;
      else
        $("#form").submit();


    });
  });
</script>