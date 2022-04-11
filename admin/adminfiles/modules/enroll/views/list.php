


  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Enroll List</h2>
    </header>

    <div class="panel-body">
      <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>
    <div class="row">
      <div class="col-sm-6">
        <div class="mb-md">
          <h2>
            <button 
            id="addButton"
            data-toggle="tooltip" 
            title="Add New Record"
            type="button" 
            class="btn btn-primary"> Add <i class="fa fa-plus"></i> </button>

            <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> More <span class="caret"></span> </button>
              <ul class="dropdown-menu" role="menu">
                <li><a onclick="cascade('delete');">Delete Marked</a></li>
                <li><a onclick="cascade('publish');">Mark as Published
</a></li>
                <li><a onclick="cascade('unpublish');">Mark as Unpublished
</a></li>
              </ul>
            </div>
          </h2>
        </div>
      </div>
    </div>
    <table class="table table-bordered table-striped mb-none" id="datatable-default">
      <thead>
        <tr>
          <th><input type="checkbox" name="all" id="checkall" ></th>
          <th>Client</th>
          <th>college</th>
          <th>Degree</th>
          <th>Course</th>
          <th>Visa</th>
          <th>Intake</th>
          <th>Fee</th>
          <th>Period</th>
          <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        foreach ($access->result() as $acc) {
          $college = $this->enrollmodel->getcollegeDetail($acc->college);
          $course = $this->enrollmodel->getcourseDetail($acc->course);
          $degree = $this->enrollmodel->getdegreeDetail($acc->degree);

          $publish = ($acc->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
          ?>
          <tr class="gradeX">
           <td><input type="checkbox" class="checkone" value="<?php echo $acc->enroll_id; ?>" /></td>
           <td><?php echo $acc->first_name.' '.$acc->last_name;?></td>
           <td><?php echo @$college->type_name;?></td>
           <td><?php echo @$degree->type_name;?></td>
           <td><?php echo @$course->type_name;?></td>
           <td><?php echo $acc->visa;?></td>
           <td><?php echo $acc->intake;?></td>
           <td><?php echo $acc->fee;?></td>
           <td><?php echo $acc->period;?></td>
           <td class="actions">

             <?php echo anchor('enroll/edit/'.$acc->enroll_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('enroll/delete/'.$acc->enroll_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
           </td>
         </tr>
         <?php
       } ?>


     </tbody>
   </table>
 </div>
</section>




</section>
</div>


</section>
<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>enroll/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });
  });
    //This function is used for making a json data for cascade delete, publish and unpublish and call ajax
    function cascade(action){
      if(confirm('Are you sure to proceed this action?')){
        var ids = checkedCheckboxId();
      if(ids.length == 0){
        alert("Select atleast one data to proceed this action");
        return false;
      }
        var jsonData ={"object":{"ids":ids,"action":action}};
        $.ajax({
          url:"<?php echo base_url(); ?>enroll/cascadeAction",
          type:"post",
          data:jsonData,
          success: function(msg){
            location.reload();
          }
        });
      }else{
        return false; 
      }
    }

  </script> 