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
                            <h4 class="mitgrate-tt">Cases</h4>
                            <div class="adding">
                            <a href="<?php echo base_url("project/add?project=1&customer=$student_id")?>"><i class="fa fa-plus"></i>Add</a>
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
                  <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
                  <th>Enrolment Number</th>
                  <th>Client</th>
                  <th>Visa Type</th>
                  <th>Sales Rep</th>
                  <th>Grand Total</th>
                  <th>Commission Rate</th>
                  <th>Commission</th>
                  <th>Added Date</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Lead Type</th>
                  <th>Is Assigned</th>
                  <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach ($enrolls->result() as $row) {
                  $assign = 0;
                  $emps = $this->projectmodel->get_projectEmployee($row->project_id);
                  if(count($emps) > 0)
                    $assign = 1;
                  $sups = $this->projectmodel->get_projectSupplier($row->project_id);
                  if(count($sups) > 0)
                    $assign = 1;
                  $publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
                  ?>
                  <tr class="gradeX">
                   <td><input type="checkbox" class="checkone" value="<?php echo $row->project_id; ?>" /></td>
                   <td><a href="<?php echo base_url("project/checklist/".$row->project_id);?>"><?php echo $row->order_no;?></a></td>
                   <td><a href="<?php echo base_url("project/case/$row->student_id/$row->enroll_id");?>"><?php echo $row->fname.' '.$row->lname;?></a></td>
                   <td><?php echo $row->visa == 14 ? 'Education':'Migration';?></td>
                   <td><?php echo $row->first_name.' '.$row->last_name;?></td>
                   <td>$<?php echo $row->grand_total;?></td>
                   <td>$<?php echo $row->commission_rate;?>%</td>
                   <td>$<?php echo $row->commission;?></td>
                   <td><?php echo date("d/m/Y",$row->added_date);?></td>
                   <td><?php echo date("d/m/Y",$row->start_date);?></td>
                   <td><?php echo date("d/m/Y",$row->end_date);?></td>
                   <td><?php echo $row->type_name;?></td>
                   <td><?php

                     if($assign == 0){
                      ?>
                      <a class="simple-ajax-popup btn-default"   href="<?php echo base_url("project/employee_assign/".$row->project_id);?>"><img src="<?php echo base_url("assets/images/notdone.png");?>"></a>
                      <?php
                    }else{
                      ?>
                      <a class="simple-ajax-popup btn-default"   href="<?php echo base_url("project/employee_assign/".$row->project_id);?>"><img src="<?php echo base_url("assets/images/done.png");?>"></a>
                      <?php
                    }
                    ?>
                  </td>

                  <td class="actions">
                    <a href="<?php echo base_url("project/note/".$row->project_id.'?project=1');?>"><i class="fa fa-comment" aria-hidden="true" data-original-title="" title=""></i></a>
                    <?php echo anchor('project/edit/'.$row->project_id.'?project=1','<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('project/delete/'.$row->project_id.'?project=1','<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
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

        window.location.href = '<?php echo base_url("project/edit")?>/'+invoice_id+'?project=1';
        });

        $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });
    });
</script>