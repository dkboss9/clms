
  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Enrolment list</h2>
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
      <div class="col-sm-12">
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

          <div class="row form-search">
          <form method="get" action="<?php echo current_url();?>">
            <table style="width:100%;">
             <tr>  
              <td style="padding:10px;">
                <select class="form-control mb-md" name="filter_by">
                  <option value="1" <?php if($search_filter == 1) echo 'selected="selected"';?>>Filter by date</option>
                  <option value="2" <?php if($search_filter == 2) echo 'selected="selected"';?>>filter by end of date </option>
                </select>
              </td>
              <td style="padding:10px;">
                <input type="text" data-plugin-datepicker="" name="start_date" value="<?php echo $search_start_date;?>" class="form-control mb-md"  placeholder="From Date" >
              </td>
              <td style="padding:10px;">
                <input type="text" data-plugin-datepicker="" name="end_date" value="<?php echo $search_end_date;?>" class="form-control mb-md" placeholder="To Date" >
              </td>
              <td style="padding:10px;">
                <select class="form-control mb-md" name="handle">
                  <option value="">Sales Rep</option>
                  <?php 
                  foreach ($users as $row ) {
                    ?>
                    <option <?php if($search_handle == $row->userid) echo 'selected="selected"';?> value="<?php echo $row->userid;?>"><?php echo $row->first_name.' '.$row->last_name;?></option>
                    <?php
                  }
                  ?>
                </select>
              </td>
              <td style="padding:10px;">
                <select class="form-control mb-md" name="project_status">
                  <option value="">Project Status</option>
                  <?php 
                  foreach ($project_status as $row ) {
                    ?>
                    <option <?php if($search_status == $row->status_id) echo 'selected="selected"';?> value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
                    <?php
                  }
                  ?>
                </select>
              </td>
              <td style="padding:10px;">
                <select class="form-control mb-md" name="is_assigned">
                  <option value="">All</option>
                  <option <?php if($search_is_assigned == 1) echo 'selected="selected"';?> value="1">Assigned</option>
                  <option <?php if($search_is_assigned == 2) echo 'selected="selected"';?> value="2">Not Assigned</option>
                </select>
              </td>
              <td style="padding:10px;">
                <input type="submit" name="search" value="search" class="btn btn-primary mb-md">
              </td>

              <tr>
              </table>
            </form>
          </div>

          </div>
        </div>
      </div>
      <table class="table table-bordered table-striped mb-none" id="datatable-example">
        <thead>
          <tr>
            <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
            <th>Enrolment Number</th>
            <th>Client</th>
            <th>Sales Rep</th>
            <th>Grand Total</th>
            <th>Commission Rate</th>
            <th>Commission</th>
            <th>Added Date</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Lead Type</th>
            <th>Is Assigned</th>
            <th>Status</th>
            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          foreach ($status->result() as $row) {
            $assign = 0;
            $emps = $this->projectmodel->get_projectEmployee($row->project_id);
            if(count($emps) > 0)
              $assign = 1;
            $sups = $this->projectmodel->get_projectSupplier($row->project_id);
            if(count($sups) > 0)
              $assign = 1;
            $publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
            ?>
            <tr class="gradeX">
             <td><input type="checkbox" class="checkone" value="<?php echo $row->project_id; ?>" /></td>
             <td><?php echo $row->order_no;?></td>
             <td><?php echo $row->fname.' '.$row->lname;?></td>
             <td><?php echo $row->first_name.' '.$row->last_name;?></td>
             <td>$<?php echo $row->grand_total;?></td>
             <td>$<?php echo $row->commission_rate;?>%</td>
             <td>$<?php echo $row->commission;?></td>
             <td><?php echo date("d/m/Y",$row->added_date);?></td>
             <td><?php echo date("d/m/Y",$row->start_date);?></td>
             <td><?php echo date("d/m/Y",$row->end_date);?></td>
             <td><?php echo $row->type_name;?></td>
             <td><?php

               if($assign == 0){
                ?>
                <a class="simple-ajax-popup btn-default"   href="<?php echo base_url("project/employee_assign/".$row->project_id);?>"><img src="<?php echo base_url("assets/images/notdone.png");?>"></a>
                <?php
              }else{
                ?>
                <a class="simple-ajax-popup btn-default"   href="<?php echo base_url("project/employee_assign/".$row->project_id);?>"><img src="<?php echo base_url("assets/images/done.png");?>"></a>
                <?php
              }
              ?>
            </td>
            <td><?php echo $row->status_name;?></td>

            <td class="actions">

              <?php echo anchor('project/edit/'.$row->project_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('project/delete/'.$row->project_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
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
    $('#datatable-example').DataTable( {
      "order": [[ 1, "desc" ]]
    } );
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>project/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this project?'))
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
          url:"<?php echo base_url(); ?>project/cascadeAction",
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