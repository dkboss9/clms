<style>
  
.modal-footer {
  margin-top: 0 !important;
}
</style>
<!-- start: page -->
<section class="panel">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
      <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
    </div>

    <h2 class="panel-title">Check In</h2>
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
      <div class="panel-wrapper collapse in">
            <div class="panel-body">
              <div class="table-wrap">
                <div class="date_title">
                  <div class="date_title_child week"> 
                    <a href="<?php echo base_url("check_in/listall?sdate=".$prev_start_date."&edate=".$prev_end_date)?>" >
                    <i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                        <span class="span_date"><?php echo date('l, jS F Y',strtotime($periods[0]));?> - <?php echo date('l, jS F Y',strtotime($periods[6])); ?></span>
                        <a href="<?php echo base_url("check_in/listall?sdate=".$next_start_date."&edate=".$next_end_date)?>" ><i class="fa fa-angle-double-right"
                        aria-hidden="true"></i></a></div>
                  <div class="date_title_child default_date">
                  
                  </div>
                </div>
                <div class="table-responsive" style="padding-top: 20px;">
                  <table border="0" cellspacing="0" cellpadding="0"
                    class="table table-hover display table_pmdoc   pb-10">
                    <tbody>
                      <tr style="background: #47a447;">
                          <?php
                           foreach($periods as $key=>$period){
                             $color = $period == $default_date ? 'font-weight: bold;background: #ddd;' : 'font-weight: bold;';
                            ?>
                            <th align="left" valign="top" style="<?php echo $color; ?>">
                           <a href="<?php echo base_url("check_in/listall?date=".$period);?>" style="color:#ffffff;"> 
                           <?php echo date('D, jS M Y',strtotime($period));?>
                          </a>
                        </th>
                          <?php } ?>
                      </tr>
           

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>

          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          </div>
          <?php  } ?>
            <?php if($attendence->num_rows() > 0)
            {
              $row = $attendence->row();
              $checkin_disable = 'disabled';
              $checkout_disable = '';
              }else{
                $checkin_disable = '';
                $checkout_disable = 'disabled';
              }

              if($default_date != date("Y-m-d")){
                $checkin_disable = 'disabled';
                $checkout_disable = 'disabled';
              }
              
              ?>

        <div class="form-group" >
          <div class="col-md-5"  >
          <p style="font-size: 20px;font-weight:bold;text-align:center;" >  Stand ups</p>
          <div  style="border: 1px solid #ddd; margin:15px;">
          <?php echo @$row->checkin_note;?>
          </div>
               
            </div>
            <div class="col-md-1" >
            </div>
            <div class="col-md-5" >
            <p style="font-size: 20px;font-weight:bold;text-align:center;" >Updates</p>
            <div  style="border: 1px solid #ddd; margin:15px;">
            <?php echo @$row->checkout_note;?>
            </div>
            </div>
          </div>
         
          <div class="form-group">
          <div class="col-md-6" style="text-align: center;">
              <a href="javascript:void(0);" <?php echo $checkin_disable;?> class="mb-xs mt-xs mr-xs btn btn-primary link_checkIn" date="<?php echo date('D, jS M Y',strtotime($period));?>" data-toggle="modal" data-target="#checkINModal">CHECK IN</a>
            </div>
            <div class="col-md-6" style="text-align: center;">
              <a href="javascript:void(0);"  <?php echo $checkout_disable;?> class="mb-xs mt-xs mr-xs btn btn-success link_checkout" date="<?php echo date('D, jS M Y',strtotime($period));?>"   data-toggle="modal" data-target="#checkOutModal">CHECK OUT</a>
            </div>
          </div>
        
  </div>
</div>
</section>
</section>
</div>
</section>

<div class="modal fade" id="checkINModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="checkInTitle">Modal title</h5>
      
      </div>
      <form name="form_checkin" id="form_checkin" method="post" action="<?php echo base_url("check_in/add")?>">
      <div class="modal-body">
        <textarea class="form-control" name="checkInNote" rows="10" required></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add stand up</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="checkOutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="checkOutTitle">Modal title</h5>
      
      </div>
      <form name="form_checkout" id="form_checkout" method="post" action="<?php echo base_url("check_in/edit")?>">
      <div class="modal-body">
        <textarea class="form-control" name="checkInNote" rows="10" required><?php echo @$row->checkout_note;?></textarea>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="data_id" value="<?php echo @$row->id;?>" >
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $("#form_checkin").validate();
    $("#form_checkout").validate();
    $(".link_checkIn").click(function(){
      var date = $(this).attr("date");
      $("#checkInTitle").html('CHECK IN:- '+date);
    });

    $(".link_checkout").click(function(){
      var date = $(this).attr("date");
      $("#checkOutTitle").html('CHECK OUT:- '+date);
    });
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>visit/add");})
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
          url:"<?php echo base_url(); ?>visit/cascadeAction",
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