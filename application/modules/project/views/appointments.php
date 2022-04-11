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
                <a href="javascript:void(0);" id="link_add appointment" data-toggle="modal"  data-target="#addGroup"><i class="fa fa-plus"></i>Add</a>
                <a href="javascript:void();" class="link_edit"><i class="fa fa-edit"></i>Edit</a>
              </div>
            </div>

          </div>
          <div>
            <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
          </div>
          <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
              <tr>
                <th><input type="checkbox" name="all" id="checkall"></th>
                <th>Appointment No.</th>
                <th>Client Name </th>
                <th>Mobile</th>
                <th>Type</th>
                <th>Appointment date</th>
                <th>Appointment time</th>
                <th>Email</th>
                <th>Country</th>
                <th>Status</th>
                <th>Counseller</th>
                <th class="sorting_disabled" aria-label="Actions">Actions</th>
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
                <td><?php echo $lead->company_name;?></td>
                <td><?php echo $lead->phone_number;?></td>
                <td><?php echo $lead->status_id == 5 ? 'Appointment':'Counceling';?></td>
                <td><?php echo $lead->booking_date ? date("d/m/Y",strtotime($lead->booking_date)):'';?></td>
                <td><?php echo $lead->booking_time;?></td>
                <td><?php echo $lead->email;?></td>
                <td><?php echo $lead->country;?></td>
              
                <td>
                  <?php echo $lead->appointment_status;?>
                </td>
                <?php
                  $handler = $this->appointmentmodel->getcompany_users($lead->consultant);
                 // echo $this->db->last_query();
                  ?>
                <td>
                  <?php echo isset($handler->first_name)?$handler->first_name.' '.$handler->last_name:'-';?>
                </td>

              
                <td class="actions">

                  <?php 
                      echo anchor('appointment/edit/'.$lead->lead_id.'?project=1','<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;';
                   
                  if($lead->consultant > 0){ ?>
                  <a href="<?php echo base_url("appointment/counselling/".$lead->lead_id);?>?project=1"><i
                      class="fa fa-book" aria-hidden="true"></i></a>
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

<!-- Add Group Popup -->
<div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Company List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo base_url("appointment/select_company");?>" method="post" id="form-addcompany">
      <div class="modal-body-addgroup">
        <div class="form-body" style="padding: 15px;">
            <div class="content">
                <div class="row">
                <div class="col-sm-3">
                    Select Company:
                </div>
                    <div class="col-sm-9">
                    <select name="root_company" id="root_company" data-plugin-selectTwo class="form-control required">
                      <option value="">Select</option>
                      <?php 
                        foreach($root_companies->result() as $company){
                          ?>
                          <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                          <?php
                        }
                      ?>
                    </select>
                    </div>
                </div>


            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    $("#form-addcompany").validate();
    $(".link_edit").click(function () {
      var chk = $(".checkone:checked").length;
      if (chk == 0) {
        alert("Please, Select invoice to edit.");
        return false;
      }
      if (chk > 1) {
        alert("Please, Select only one invoice to edit.");
        return false;
      }
      var invoice_id = 0;
      $(".checkone:checked").each(function () {
        invoice_id = $(this).val();
      });

      window.location.href = '<?php echo base_url("appointment/edit")?>/' + invoice_id + '?project=1';
    });
  });
</script>