
<div id="custom-content" class="white-popup-block white-popup-block-md">


  <form method="post"  action="<?php echo base_url("project/employee_assign");?>">

    <div class="row">
      <div class="col-sm-12">
        <h3>Assign Employee</h3></hr>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label" for="note">Admin Note</label>
      <div class="col-md-9">

        <textarea name="note" class="form-control" id="note" ><?php echo $result->note;?></textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label">Add Employee</label>
      <div class="col-md-9">
        <div class="input-group">

          <?php 
          foreach ($employees as $row) {
            $emp = $this->projectmodel->getEmployeeDetails($row->id,$project_id);
            ?>
            <div class="checkbox-custom checkbox-primary col-md-6">
             <input type="checkbox" value="<?php echo $row->id;?>" name="employee[]" <?php if($emp > 0) echo 'checked="checked"'; ?> id="checkboxExample2">
             <label for="checkboxExample2"> &nbsp;&nbsp;&nbsp;<?php echo $row->first_name.' '.$row->last_name; ?></label>
           </div>
           <?php
         }
         ?>
       </div>
     </div>
   </div>
   <div class="form-group">
    <label class="col-md-3 control-label">Add Supplier</label>
    <div class="col-md-9">
      <div class="input-group">

        <?php 
        foreach ($suppliers as $row) {
          $emp = $this->projectmodel->getSupplierDetails($row->id,$project_id);
          ?>
          <div class="checkbox-custom checkbox-primary col-md-6">
           <input type="checkbox" value="<?php echo $row->id;?>" name="supplier[]" <?php if($emp > 0) echo 'checked="checked"'; ?> id="checkboxExample2">
           <label for="checkboxExample2">&nbsp;&nbsp;&nbsp;<?php echo $row->first_name.' '.$row->last_name; ?></label>
         </div>
         <?php
       }
       ?>
     </div>
   </div>
 </div>
 


 <div class="row mb-lg">
  <div class="col-sm-9 col-sm-offset-3">
  <input type="hidden" value="<?php echo $project_id;?>" name="project_id">
  <input type="hidden" value="<?php echo $this->input->get("project")??0;?>" name="project">
    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    <button type="reset" class="btn btn-default">Reset</button>
  </div>
</div>

</form>

</div>


<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>
