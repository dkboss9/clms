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
                            <h4 class="mitgrate-tt">Collected Points</h4>
                            <div class="adding">
                                <?php  
                                 if($this->session->userdata("clms_front_user_group") != 14) {
                                     ?>
                                    <a href="javascript:void();" class="link_add"><i class="fa fa-plus"></i>Add</a>
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
                  <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
                  <th>Enrolment Number</th>
                  <th>Client</th>
                  <th>Visa Type</th>
                  <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Points</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach ($enrolls->result() as $row) {
                
                  ?>
                  <tr class="gradeX">
                   <td><input type="checkbox" class="checkone" value="<?php echo $row->enroll_id; ?>" /></td>
                   <td><a href="<?php echo base_url("project/checklist/".$row->project_id);?>"><?php echo $row->order_no;?></a></td>
                   <td><a href="<?php echo base_url("project/case/$row->student_id/$row->enroll_id");?>"><?php echo $row->fname.' '.$row->lname;?></a></td>
                   <td><?php echo $row->visa == 14 ? 'Education':'Migration';?></td>
                  <td class="actions">
                      <?php echo $row->collected_points;?>
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
<div class="modal fade" id="collectedPoints" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content case-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Collected Points</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_case" action="javascript:addCollectedPoints();">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label case-label">Enrollments</label>
                        <div class="col-md-6">
                           <select name="enrollment" id="enrollment" class="form-control" required>
                               <option value="">Select</option>
                               <?php
                                    foreach($enroll_projects->result() as $project){
                               ?>
                                        <option value="<?php echo $project->enroll_id;?>"><?php echo $project->order_no;?></option>
                                <?php } ?>
                           </select>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-4 control-label case-label">Collected Points</label>
                            <div class="col-md-6">
                               <input type="number" min="0" class="form-control" name="collected_points" id="collected_points" value="<?php echo $point->points??0;?>">
                            </div>
                          
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="col-md-4 control-label case-label"></label>
                        <div class="col-md-6">
                           <input type="checkbox" name="send_email" id="send_email" value="1"> Send Email
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">YES</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".link_add").click(function(){
           $("#collectedPoints").modal("show");
        });
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
            var enrollment = 0;
            $(".checkone:checked").each(function(){
                enrollment = $(this).val();
            });

            $("#enrollment").val(enrollment);

            $.ajax({
                url: '<?php echo base_url() ?>project/getEnroll',
                type: "POST",
                data: {
                    enrollment:enrollment,
                    },
                success: function(data) { 
                   $("#collected_points").val(data);
                }        
            });

            $("#collectedPoints").modal("show");
        });
     
    });
    function addCollectedPoints(){
          var enrollment = $("#enrollment").val();
          var collected_points = $("#collected_points").val();

          $.ajax({
                url: '<?php echo base_url() ?>project/add_collectedPoints',
                type: "POST",
                data: {
                    enrollment:enrollment,
                    collected_points:collected_points
                    },
                success: function(data) { 
                    location.reload();
                }        
            });
      }
</script>