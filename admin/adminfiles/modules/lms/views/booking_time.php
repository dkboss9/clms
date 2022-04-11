<div id="w4-billing" class="tab-pane">
  <?php
  foreach($days as $day){
    $times = $this->employeemodel->get_service_time($employee_id,$day->day_id);
    if($times){
      $start = date('H:i',strtotime(@$times->service_start_time));
      $end =  date('H:i',strtotime(@$times->service_end_time));
    }
    ?>
    <input type="hidden" name="day_id[]" value="<?php echo $day->day_id;?>" class="day_id">
    <div class="form-group">
      <label class="col-md-3 control-label" for="productivity"><?php echo $day->day_name; ?></label>
      <div class="col-md-3">
       <select name="start_time[]" id="start_time<?php echo $day->day_id;?>" class="form-control start_time">
        <?php  for ($i=0;$i<=23;$i++){
          for ($j=0;$j<=45;$j=$j+15)
          {
            $time_interval = $i.':'.str_pad($j, 2, '0', STR_PAD_LEFT);
            $time_interval = date('H:i',strtotime($time_interval));
            ?>
            <option value="<?php echo $time_interval;?>" <?php if(@$start == $time_interval) echo 'selected="selected"'; ?>><?php echo $time_interval;?></option>
            <?php
          }
        }?>
      </select>
    </div>
    <div class="col-md-3">
      <select name="end_time[]" id="end_time<?php echo $day->day_id;?>" class="form-control end_time">
        <?php  for ($i=0;$i<=23;$i++){
          for ($j=0;$j<=45;$j=$j+15)
          {
            $time_interval = $i.':'.str_pad($j, 2, '0', STR_PAD_LEFT);
            $time_interval = date('H:i',strtotime($time_interval));
            ?>
            <option value="<?php echo $time_interval;?>" <?php if(@$end == $time_interval) echo 'selected="selected"'; ?>><?php echo $time_interval;?></option>
            <?php
          }
        }?>
      </select>
    </div>
    <label class="col-md-3 control-label"  id="err_serivce<?php echo $day->day_id;?>"></label>
  </div>
  <?php } ?>
</div>
