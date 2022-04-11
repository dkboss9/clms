
<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>

<script src="<?php echo base_url("");?>assets/vendor/chartist/chartist.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.categories.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.resize.js"></script>


<style>
 .activeClass{
   background-color: #86D1FD;
 }
 .top-icon li{
  list-style: none;
  display: inline-block;
  padding: 0% 3.3%;
}
.top-icon li a i{
  font-size: 36px;
}
.project-calender a i{
  font-size: 45px;
  display: block;
}
.project-calender a{
  color: green;
  text-align: center;
}
.event-calender a i{
  font-size: 45px;
  display: block;
}
.event-calender a{
  color: pink;
  text-align: center;
}
.task-calender a i{
  font-size: 45px;
  display: block;
}
.task-calender a{
  color: orange;
  text-align: center;
}
@media(max-width: 767px){
  .top-icon li{
    padding: 0% 2.5%;
  }
}
</style>


<!-- start: page -->

<?php 
//$this->load->view("dashboard_count");
?>
<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message") ?>
</div>
<?php
}
?>
<div class="row">
  <section class="panel">
  <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle=""></a>
        <a href="#" class="" data-panel-dismiss=""></a>
      </div>

      <h2 class="panel-title">Counselling</h2>
    </header>
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
                  <th><input type="checkbox" name="all" id="checkall" ></th>
                  <th>Sn.</th>
                  <th>Client Name </th>
                  <th>Mobile</th>

                  <th>Appointment date</th>
                  <th>Appointment time</th>
                  <th>Email</th>
                  <th>Country</th>
                  <th>Counselling By</th>
                  <th>Status History</th>
                  <th class="sorting_disabled"  aria-label="Actions" >Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 

                foreach ($councelling->result() as $lead) {
                 $publish = ($lead->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
                 ?>
                 <tr class="gradeX">
                  <td><input type="checkbox" class="checkone" value="<?php echo $lead->lead_id; ?>" /></td>
                  <td><?php echo $lead->lead_id;?></td>
                  <td><?php echo $lead->lead_name.' '.$lead->lead_lname;?></td>
                  <td><?php echo $lead->phone_number;?></td>

                  <td><?php echo date("d/m/Y",strtotime($lead->booking_date));?></td>
                  <td><?php echo $lead->booking_time;?></td>
                  <td><?php echo $lead->email;?></td>
                  <td><?php echo $lead->country;?></td>
                  <?php 
                  $handler = $this->appointmentmodel->getcompany_users($lead->consultant);
                  ?>
                  <td><?php echo !empty($handler)?$handler->first_name.' '.$handler->last_name:'<a class="simple-ajax-popup-reminder btn-default"   href="'.base_url("appointment/add_consultant/".$lead->lead_id).'"> <i class="fa fa-user-plus"></i></a>';?></td>
                  <td>
                    <?php 
                    $updates = $this->appointmentmodel->get_updates($lead->lead_id);
                    if(count($updates)>0){
                      ?>
                      <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("appointment/detail/".$lead->lead_id);?>?tab=counselling"><img src="<?php echo base_url()."assets/images/history.png";?>"></a>
                      <?php }else{ ?>
                      <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("appointment/detail/".$lead->lead_id);?>?tab=counselling">N/A</a>
                      <?php   }?>
                    </td>

                    <td class="actions">
                      <?php 
                      echo anchor('appointment/edit/'.$lead->lead_id.'?tab=counselling','<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;';
                      if($this->session->userdata("usergroup") == 1)
                        echo anchor('appointment/delete/'.$lead->lead_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
                      <?php if($this->session->userdata("usergroup") == 1){ ?>
                      <a href="<?php echo base_url("lms/send_email/".$lead->lead_id);?>" class="mail"><i class="fa fa-mail-forward"></i></a>
                      <?php } ?>
                      <a href="<?php echo base_url("student/add/".$lead->lead_id);?>">  <i class="fa fa-user-md"></i></a>
                      <a href="<?php echo base_url("project/add/".$lead->lead_id);?>"><i class="fa fa-cubes" aria-hidden="true"></i></a>
                      <a href="<?php echo base_url("appointment/counselling/".$lead->lead_id);?>" class="btn btn-primary" style="color:#fff"><i class="fa fa-book" aria-hidden="true"></i> Start Counselling</a>
                    
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
    $('.fa-mail-forward').tooltip({'placement': 'bottom','title':'Email'});
    $(".fa-user-md").tooltip({'placement': 'bottom','title':'Add Client'});
    $(".fa-book").tooltip({'placement': 'bottom','title':'Add counselling'});
    $(".fa-cubes").tooltip({'placement': 'bottom','title':'Add Order'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>appointment/add?tab=counselling");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });

    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });

     $('#datatable-default').DataTable( {
      "order": [[ 1, "desc" ]]
    } );

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
        url:"<?php echo base_url(); ?>appointment/cascadeAction",
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
