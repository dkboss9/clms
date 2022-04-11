


<!-- start: page -->
<section class="panel">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
      <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
    </div>

    <h2 class="panel-title">Company List</h2>
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
              <li><a onclick="cascade('publish');">Mark as Publish</a></li>
              <li><a onclick="cascade('unpublish');">Mark as Unpublish</a></li>
            </ul>
          </div>
        </h2>
      </div>
    </div>
  </div>
  <table class="table table-bordered table-striped mb-none" id="datatable-default">
    <thead>
      <tr>
        <th style="width:10%"><input type="checkbox" name="all" id="checkall" ></th>
        <th>Title</th>
        <th>Company Name</th>
        <th>Package Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Username</th>
        <th>Invoice status</th>
        <th>Expiry Date</th>

        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($company->result() as $row) {

        $d1 = $row->expiry_date;
        $d2 = time();

        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $i = 0;

        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
          $i++;
        }
          //echo $i;
        $publish = ($row->status == 1 ? '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span></a>' : '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span></a>');
        ?>
        <tr class="gradeX" <?php if($i < 1 || $d1 < $d2) echo 'style="background-color:#FAEBD7;"';?>>
         <td><input type="checkbox" class="checkone" value="<?php echo $row->userid; ?>" /></td>
         <td><?php echo $row->first_name.' '.$row->last_name;?></td>
         <td><?php echo $row->company_name;?></td>
         <td><?php echo @$this->companymodel->get_packageDetails($row->package_id)->name;?></td>
         <td><?php echo $row->phone;?></td>
         <td><?php echo $row->email;?></td>
         <td><?php echo $row->user_name;?></td>
         <td><?php echo @$row->invoice_status;?></td>
         <td><?php echo date("d/m/Y",$row->expiry_date);?></td>
         
         <td class="actions">

          <?php
          echo $publish.'&nbsp;';
          echo anchor('company/edit/'.$row->userid,'<span class="fa fa-cog"></span>',array("class"=>""));
         // if($row->user_group!='1' && $row->user_group!='2'){
            echo ' <a href="'. base_url(""). 'users/perm_modify_per_package/'. $row->userid .'"  class=""><span class="glyphicon glyphicon-asterisk">&nbsp;</span></a>';
         // }
         
          ?>
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
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>company/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Announcement?'))
        return false;
    });
  });


  function cascade(action){

    confirmation("Confirmation","Are you sure you want to proceed this Action? ","Cancel","Confirm","",action,"<?php echo base_url(); ?>company/cascadeAction");

  }

</script> 