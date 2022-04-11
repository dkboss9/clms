


  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Supplier List</h2>
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
          <th>Name</th>
          <th>Company Name</th>
          <th>Eamil</th>
          <th>Phone</th>
          <th>Location</th>
          <th>Product</th>
          <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        foreach ($access->result() as $acc) {
         $publish = ($acc->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
         ?>
         <tr class="gradeX">
           <td><input type="checkbox" class="checkone" value="<?php echo $acc->id; ?>" /></td>
           <td><?php echo $acc->name;?></td>
           <td><?php echo $acc->company_name;?></td>
          <td><?php echo $acc->email;?></td>
          <td><?php echo $acc->phone;?></td>
          <td><?php echo $acc->address;?></td>
          <td><?php echo $acc->product;?></td>
          <td class="actions">

            <?php 
            if($acc->company_id > 0 OR $this->session->userdata("usergroup") == '1')
              echo anchor('start_supplier/edit/'.$acc->id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('start_supplier/delete/'.$acc->id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));
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
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>start_supplier/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Agent?'))
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
          url:"<?php echo base_url(); ?>start_supplier/cascadeAction",
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