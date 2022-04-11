


  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">SMS Subscriber List</h2>
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
          <th>Mobile No.</th>
          <th>Email Address</th>
          <th>Name</th>
          <th>Type</th>
          <th>Subscription Date</th>
          <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        foreach ($sms_subscribers->result() as $start) {
         $publish = ($start->status == 1 ? '<span class="glyphicon glyphicon-ok-sign btn-success list-btn btn" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign btn-danger list-btn btn" data-toggle="tooltip" title="Unpublished"></span>');
         ?>
         <tr class="gradeX">
           <td><input type="checkbox" class="checkone" value="<?php echo $start->subscription_id; ?>" /></td>
           <td><?php echo $start->mobile_number;?></td>
           <td><?php echo $start->email_address;?></td>
           <td><?php echo $start->name;?></td>
            <td><?php echo $start->group;?></td>
           <td><?php echo date("d-m-Y",strtotime($start->subscription_date));?></td>

           <td class="actions" >

             <?php echo anchor('sms_subscribers/edit/'.$start->subscription_id,'<span class="glyphicon glyphicon-edit btn-primary list-btn btn"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('sms_subscribers/delete/'.$start->subscription_id,'<span class="glyphicon glyphicon-trash btn-danger list-btn btn"></span>',array('class'=>"link_delete"));?>
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
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>sms_subscribers/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Subscriber?'))
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
          url:"<?php echo base_url(); ?>sms_subscribers/cascadeAction",
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