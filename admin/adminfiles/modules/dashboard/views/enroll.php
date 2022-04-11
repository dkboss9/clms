

<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message") ?>
</div>
<?php
}
?>

    
<header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle=""></a>
        <a href="#" class="" data-panel-dismiss=""></a>
      </div>

      <h2 class="panel-title">Cases</h2>
    </header>

<div class="row">
  <section class="panel">
    <div class="panel-body">
      <div class="tabs tabs-warning">
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
                  <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
                  <th>Enrolment Number</th>
                  <th>Client</th>
                  <th>Visa Type</th>
                  <th>Sales Rep</th>
                  <th>Grand Total</th>
                  <th>Commission Rate</th>
                  <th>Commission</th>
                  <th>Added Date</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Lead Type</th>
                  <th>Is Assigned</th>
                  <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach ($enrolls->result() as $row) {
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
                   <td><a href="<?php echo base_url("project/checklist/".$row->project_id);?>"><?php echo $row->order_no;?></a></td>
                   <td><a href="<?php echo base_url("project/case/$row->student_id/$row->enroll_id");?>"><?php echo $row->fname.' '.$row->lname;?></a></td>
                   <td><?php echo $row->visa == 14 ? 'Education':'Migration';?></td>
                   <td><?php echo $row->first_name.' '.$row->last_name;?></td>
                   <td>$<?php echo $row->grand_total;?></td>
                   <td><?php echo $row->commission_rate;?>%</td>
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

                  <td class="actions">
                    <a href="<?php echo base_url("project/note/".$row->project_id);?>"><i class="fa fa-comment" aria-hidden="true" data-original-title="" title=""></i></a>
                    <?php echo anchor('project/edit/'.$row->project_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('project/delete/'.$row->project_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
                  </td>
                </tr>
                <?php
              } ?>


            </tbody>
          </table>
       
    </div>
  </div>
</section>
</div>


</section>
</div>
</section>

<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('.fa-comment').tooltip({'placement': 'bottom','title':'Note'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>project/add?tab=1");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });

    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });

  });

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
