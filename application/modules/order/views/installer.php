

<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url("");?>assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">


  $(document).ready(function(){
    $('#details123').trumbowyg();
  });
</script>
<!-- start: page -->


<?php 
if($this->session->flashdata("success_message"))
{
  ?>
  <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message");?>
  </div>
  <?php
}
?>

<div class="row">
  <div class="col-md-12">
    <div class="tabs tabs-warning">
    

            <div class="tab-content">
              <div id="leads" class="tab-pane <?php if(!$this->input->get("tab")) echo 'active';?>">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-md">
                      <a href="<?php echo base_url("order/callendar");?>"  class="mb-xs mt-xs mr-xs btn btn-default">Contractor Callendar</a>
                   
                      <!-- <a class="mb-xs mt-xs mr-xs btn btn-default"  href="<?php echo base_url("order/activity_report");?>">Activity Report</a> -->
                    
            
              </div>
            </div>
            <div class="col-sm-12">
              <div class="mb-md">
                <h2>
                <?php 
                      if($this->session->userdata("clms_front_user_group") == 11){
                        ?>
                  <button              
                  type="button" 
                  class="btn btn-primary btn-addactivity"  data-toggle="modal" data-target="#myModal"> Add Activity<i class="fa fa-plus"></i> </button>
                  <?php } ?>
                  <!-- Single button -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle btn-more" data-toggle="dropdown"> More <span class="caret"></span> </button>
                    <ul class="dropdown-menu" role="menu">
                      <?php 
                      foreach ($installer_status->result() as $status) {
                        if($this->session->userdata("clms_front_user_group") == 11){
                          if($status->threatre_id == 23 || $status->threatre_id == 28){
                        ?>
                        <li><a onclick="cascade(<?php echo $status->threatre_id?>);"><?php echo $status->name;?> </a></li>
                        <?php
                          }
                        }else{
                          ?>
                            <li><a onclick="cascade(<?php echo $status->threatre_id?>);"><?php echo $status->name;?> </a></li>
                          <?php
                        }
                      }
                      ?>


                    </ul>
                  </div>
                   
                  <?php /*   <a href="<?php echo base_url("dashboard/export_order?status=$ostatus&invoice=$invoice");?>" class="btn btn-primary"> Export  </a> */?>
                </h2>

              </div>
            </div>
          </div>

          <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
              <tr>
                <th style="width:2%;">
                <!-- <input type="checkbox" name="all" id="checkall" > -->
                </th>
                <th>Order Number</th>
                <th>Nature of Project</th>
                <th>Customer</th>
                <th>Address</th>
                <th>Contractor</th>
               
                <th>Contractor Status</th>
                <th>Date & Time</th>
                <th>Deadline</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php 
              foreach ($installer->result() as $row) {
               $counter = $this->ordermodel->getinstallemailcount($row->id);
               $orderseen = $this->ordermodel->countinstallseen($row->id);
               $installers = $this->ordermodel->getorder_installer($row->order_id);
               //echo $this->db->last_query();
               ?>
               <tr class="gradeX">
                <td style="width:2%;"><input type="checkbox" class="checkone" value="<?php echo $row->id; ?>" group="<?php echo $this->session->userdata("clms_front_user_group");?>" status="<?php echo $row->install_status;?>" /></td>
                <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("order/notes/".$row->order_id);?>"><?php echo $row->order_number;?></a></td>
                <td><?php echo $row->product; ?></td>
                <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$row->first_name;?> <?php echo @$row->first_name;?></a></td>
                <td><?php echo $row->address;?></td>
                <td>
                  <?php foreach($installers as $key => $installer1){?>
                    <?php echo $key + 1; ?>.  <a class="simple-ajax-popup btn-default" href="<?php echo base_url("installer/details/".$installer1->threatre_id);?>"><?php echo $installer1->first_name.' '.$installer1->last_name;?>(<?php echo $installer1->position_type;?>)</a>
                    <br> 
                  <?php } ?>
                </td>
             
                <td>
                <span class="label" style="color:#fff;background:<?php echo @$row->color_code;?>"><?php echo @$row->name;?></span>
                    <?php 
                     if($this->session->userdata("clms_front_user_group") == 11){
                      if($row->threatre_id == 22){
                        echo '<a href="javascript:void();" class="" onclick="change_satus('.$row->id.',25)" >Make confirm</a>';
                      }elseif($row->threatre_id == 25){
                        echo '<a href="javascript:void();" class="" onclick="change_satus('.$row->id.',23)" >Make Finished</a>';
                      }
                    }
                     ?>
                </td>
                <td><?php echo date("D",strtotime($row->installed_date));?>,<?php echo date("d/m/Y",strtotime($row->installed_date));?> at <?php echo $row->installed_time;?></td>
                <td><?php echo date("D",strtotime($row->installed_date));?>,<?php echo date("d/m/Y",strtotime($row->deadline_date));?> at <?php echo $row->deadline_time;?></td>
                <td style="width: 15%">
                  <!-- <a href="<?php echo base_url("order/mail_preview_installer/".$row->id);?>?tab=1" class="link_email simple-ajax-popup123 ""><span class="glyphicon glyphicon-envelope"></span> (<?php echo  $counter;?>)</a> -->
                  <a href="javascript:void(0);" class=""><span class="glyphicon glyphicon-envelope"></span> (<?php echo  $counter;?>)</a>
                  <a href="javascript:void(0);" class="">   <i class="fa fa-eye"></i> (<?php echo $orderseen;?>) </a>
                </td>

              </tr>

              <?php
            } ?>


          </tbody>
        </table>
      </div>
      <div id="customer" class="tab-pane <?php if($this->input->get("tab") && $this->input->get("tab") == "patient") echo 'active';?>">


      </div>
      <div id="quote" class="tab-pane <?php if($this->input->get("tab") && $this->input->get("tab") == "patient") echo 'active';?>">


      </div>
      <div id="orders" class="tab-pane <?php if($this->input->get("tab") && $this->input->get("tab") == "order") echo 'active';?>">


      </div>
    </div>
  </div>
</div>

</div>
<!-- start: page -->
<!--
<div class="row">
  <div class="col-md-6 col-lg-12 col-xl-6">
    <section class="panel">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="chart-data-selector ready" id="salesSelectorWrapper">

             <div id="datepicker">Welcome to Delite Coupons.</div>

           </div>
         </div>

       </div>
     </div>
   </section>
 </div>
 
</div>
-->
<!-- Form -->
<!-- end: page -->

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Daily Progress Report</h4>
      </div>
      <form name="form_activity" id="form_activity" action="<?php echo base_url("order/add_activity")?>" method="POST">
      <div class="modal-body" id="form_dailyact">
      <span style="float: right;"><?php echo date("M, d-m-Y");?></span>
      <a href="javascript:void(0);"  class="mb-xs mt-xs mr-xs btn btn-default" id="btn-yesterday"><?php echo date('l',strtotime("-1 days"));?></a>
      <a href="javascript:void(0);"  class="mb-xs mt-xs mr-xs btn btn-success" id="btn-today"><?php echo date("l");?></a>
              <?php 
              foreach ($installer_activity->result() as $row) {
                ?>
              <table class="table table-bordered table-striped mb-none" id="datatable-default1" style="margin-bottom: 20px !important;">
                <thead>
                  <tr>
                    <th>Order Number</th>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Time</th>
                  </tr>
                </thead>
                <tbody>
                <?php
               $counter = $this->ordermodel->getinstallemailcount($row->id);
               $orderseen = $this->ordermodel->countinstallseen($row->id);
               $installers = $this->ordermodel->getorder_installer($row->order_id);
               //echo $this->db->last_query();
               ?>
               <tr class="gradeX">
                <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("order/notes/".$row->order_id);?>"><?php echo $row->order_number;?></a></td>
                <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$row->customer_name;?></a></td>
                <td><?php echo $row->delivery_address1.', '.$row->delivery_suburb.','.$this->ordermodel->getState($row->delivery_state);?></td>
                
                <td><?php echo date("D",strtotime($row->installed_date));?>,<?php echo date("d/m/Y",strtotime($row->installed_date));?></td>
                <td><?php echo $row->installed_time;?></td>
              </tr>
                </tbody>
            </table>
            <div class="form-group">
              <label class="col-md-2 control-label">Start Time</label>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text"  data-plugin-timepicker="" value="" name="start_time[]" id="start_time" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }"  >
                </div>
              </div>
              <label class="col-md-2 control-label">End Time</label>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </span>
                  <input type="text" data-plugin-timepicker="" name="end_time[]" value="" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }"  >
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea name="note[]" id="note" class="form-control"></textarea>
              </div>
            </div>
                <input type="hidden" name="order_id[]" value="<?php echo $row->order_id;?>">
              <?php
            } ?>
      </div>
      <div class="modal-footer" style="clear: both;margin-top: 0px;">
        <input type="hidden" name="txt_day" id="txt_day" value="1">
        <button type="submit" class="btn btn-success" >Add Activity</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
</section>
</div>
</section>
<script type="text/javascript">
  $(document).ready(function(){
    $("#btn-today").click(function(){ 
      $(this).removeClass("btn-default");
      $(this).addClass("btn-success");

      $("#btn-yesterday").removeClass("btn-success");
      $("#btn-yesterday").addClass("btn-default");

      $("#txt_day").val(1);
    });

    $("#btn-yesterday").click(function (){
      $(this).removeClass("btn-default");
      $(this).addClass("btn-success");

      $("#btn-today").removeClass("btn-success");
      $("#btn-today").addClass("btn-default");

      $("#txt_day").val(0);
    });

    $('.glyphicon-user').tooltip({'placement': 'bottom','title':'Assign to Contractor'});
    $('.fa-dollar').tooltip({'placement': 'bottom','title':'Payment'});
    $('#datatable-default').DataTable( {
      "order": [[ 1, "desc" ]]
    } );
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
   // $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>order/add?tab=1");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });

    $(".checkone").click(function () { 
      $(".checkone").prop('checked', false);
      $(this).prop("checked",true);
      var status = $(this).attr("status");
      var group = $(this).attr("group");
      if(group == 11 && status == 22){
        $(".btn-more").attr("disabled",true);
      }else{
        $(".btn-more").attr("disabled",false);
      }
    });

    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });
  });

  // function cascade(status){   
  //   if(confirm('Are you sure to proceed this action?')){
  //     var ids = checkedCheckboxId();
      if(ids.length == 0){
        alert("Select atleast one data to proceed this action");
        return false;
      }
    
  //     var jsonData ={"object":{"ids":ids,"status":status}};
  //     $.ajax({
  //       url:"<?php echo base_url(); ?>order/cascadeInstallerAction",
  //       type:"post",
  //       data:jsonData,
  //       success: function(msg){
  //      //  location.reload();
  //      }
  //    });
  //   }else{
  //     return false; 
  //   }
  // }

  function change_satus(id,status){
    confirmation("Confirmation","Are you sure you want to proceed this Action? ","Cancel","Confirm","",status,"<?php echo base_url(); ?>order/change_status/"+id+"/"+status);
  }

  function cascade(action){
    var ids = checkedCheckboxId();
      if(ids.length == 0){
        alert("Select atleast one data to proceed this action");
        return false;
      }
    if(ids.length == 0){
      alert("Please select the data first to preceed this action.");
      return;
    }
     
    confirmation("Confirmation","Are you sure you want to proceed this Action? ","Cancel","Confirm","",action,"<?php echo base_url(); ?>order/cascadeInstallerAction");
    
  }

  
</script>
