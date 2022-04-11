<!-- start: page -->
<section class="panel">
    <div class="panel-body case-body">
    <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>
       <?php $this->load->view("tab");?>
    <div class="migrate-menu">
            <div class="row">
                <div class="col-sm-12">
                    <div class="migrate-menu-list">
                        <div class="mig-top-sec">
                            <h4 class="mitgrate-tt">Appointment/Councelling</h4>
                            <div class="adding">
                              <?php   if($this->usermodel->checkperm_view('appointment',"EDIT")) {?>
                                <a href="<?php echo base_url("appointment/add?project=1&student_id=$student_id")?>"><i class="fa fa-plus"></i>Add</a>
                              <?php } ?>
                             <?php  if($this->usermodel->checkperm_view('appointment',"EDIT")){ ?>
                                <a href="javascript:void();" class="link_edit"><i class="fa fa-edit"></i>Edit</a>
                                <?php }?>
                            </div>
                        </div>
                    
                    </div>
                        <div>
                            <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                        </div>
                        <table class="table table-bordered table-striped mb-none" id="datatable-default">
              <thead>
                <tr>
                  <th><input type="checkbox" name="all" id="checkall" ></th>
                  <th>Appointment No.</th>
                  <th>Client Name </th>
                  <th>Mobile</th>
                  <th>Type</th>
                  <th>Appointment date</th>
                  <th>Appointment time</th>
                  <th>Email</th>
                  <th>Country</th>
                  <th>Lead By</th>
                  <th>Counseller</th>
                  <th>Status History</th>
                  <th class="sorting_disabled"  aria-label="Actions" >Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 

                foreach ($appointments->result() as $lead) {
                 $publish = ($lead->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
                 ?>
                 <tr class="gradeX">
                  <td><input type="checkbox" class="checkone" value="<?php echo $lead->lead_id; ?>" /></td>
                  <td><?php echo $lead->lead_id;?></td>
                  <td><?php echo $lead->lead_name.' '.$lead->lead_lname;?></td>
                  <td><?php echo $lead->phone_number;?></td>
                  <td><?php echo $lead->status_id == 5 ? 'Appointment':'Counceling';?></td>
                  <td><?php echo date("d/m/Y",strtotime($lead->booking_date));?></td>
                  <td><?php echo $lead->booking_time;?></td>
                  <td><?php echo $lead->email;?></td>
                  <td><?php echo $lead->country;?></td>
                  <?php 
                  $handler = $this->lmsmodel->getusers($lead->handle);
                  ?>
                  <td><?php echo @$handler->user_name;?></td>
                  <?php
                  $handler = $this->appointmentmodel->getcompany_users($lead->consultant);
                 // echo $this->db->last_query();
                  ?>
                  <td><?php echo isset($handler->first_name)?$handler->first_name.' '.$handler->last_name:'<a class="simple-ajax-popup-reminder btn-default"   href="'.base_url("appointment/add_consultant/".$lead->lead_id).'"> <i class="fa fa-user-plus"></i></a>';?></td>
                  <td>
                  <?php if($this->session->userdata("clms_front_user_group") != 14) {?>
                    <?php 
                    $updates = $this->appointmentmodel->get_updates($lead->lead_id);
                    if(count($updates)>0){
                      ?>
                      <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("appointment/detail/".$lead->lead_id);?>?project=1"><img src="<?php echo base_url()."assets/images/history.png";?>"></a>
                      <?php }else{ ?>
                      <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("appointment/detail/".$lead->lead_id);?>?project=1">N/A</a>
                      <?php   }?>
                      <?php } ?>
                    </td>
                     
                    <td class="actions">
                    <?php if($this->session->userdata("clms_front_user_group") != 14) {?>
                      <?php 
                      echo anchor('appointment/edit/'.$lead->lead_id.'?project=1','<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;';
                      if($this->session->userdata("clms_front_user_group") == 1)
                        echo anchor('appointment/delete/'.$lead->lead_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
                      <?php if($this->session->userdata("clms_front_user_group") == 1){ ?>
                      <a href="<?php echo base_url("lms/send_email/".$lead->lead_id);?>" class="mail"><i class="fa fa-mail-forward"></i></a>
                      <?php } ?>
                      <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("appointment/add_consultant/".$lead->lead_id);?>?project=1"> <i class="fa fa-user-plus"></i></a>
                      <?php } ?>
                      <?php if($lead->consultant > 0){ ?>
                      <a href="<?php echo base_url("appointment/counselling/".$lead->lead_id);?>?project=1"><i class="fa fa-book" aria-hidden="true"></i></a>
                      <?php } ?>
                     
                    </td>
                  
                  </tr>
                  <?php
                } ?>


              </tbody>
            </table>

                </div>
            </div>
        </div>
    </div>
</section>

</section>
</div>


</section>
<script>
  $(document).ready(function(){
    $(".link_edit").click(function(){
      var chk = $(".checkone:checked").length;
      if(chk == 0){
        alert("Please, Select invoice to edit.");
        return false;
      }
      if(chk > 1){
        alert("Please, Select only one invoice to edit.");
        return false;
      }
      var invoice_id = 0;
      $(".checkone:checked").each(function(){
        invoice_id = $(this).val();
      });

      window.location.href = '<?php echo base_url("appointment/edit")?>/'+invoice_id+'?project=1';
    });
  });
</script>