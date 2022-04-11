
<!-- start: page -->
<section class="panel">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
      <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
    </div>

    <h2 class="panel-title">Package List</h2>
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
        <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
        <th>Title</th>
        <th>Price</th>
        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" >Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($status->result() as $row) {
       $publish = ($row->status == 1 ? '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span></a>' : '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span></a>');
       ?>
       <tr class="gradeX">
         <td><input type="checkbox" class="checkone" value="<?php echo $row->threatre_id; ?>" /></td>
         <td><?php echo $row->name;?></td>
         <td><?php echo $row->price;?></td>
         <td class="actions">
          <?php echo anchor('inverter/edit/'.$row->threatre_id,'<span class="glyphicon glyphicon-edit"></span>',array("class"=>"")).'&nbsp;'.$publish;?>
          <a href="javascript:void(0);" onclick='return  confirmation("Confirmation","Are you sure you want to delete the item? ","Cancel","Confirm","<?php echo base_url('inverter/delete/'.$row->threatre_id)?>");' class="" ><span class="glyphicon glyphicon-trash"></span></a>
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
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>inverter/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });
  });
   

    function cascade(action){

      confirmation("Confirmation","Are you sure you want to proceed this Action? ","Cancel","Confirm","",action,"<?php echo base_url(); ?>inverter/cascadeAction");

    }

  </script> 