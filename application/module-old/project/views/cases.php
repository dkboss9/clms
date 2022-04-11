<!-- start: page -->
<section class="panel">
    <div class="panel-body case-body">

       <?php $this->load->view("tab");?>
    <div class="migrate-menu">
            <div class="row">
                <div class="col-sm-12">
                    <div class="migrate-menu-list">
                        <div class="mig-top-sec">
                            <h4 class="mitgrate-tt"><?php echo $enroll->visa == 14 ? 'Enrollment Flow' : 'Migration Flow';?> : <strong>#<?php echo $project->order_no;?></strong></h4>
                            <div class="adding">
                            <a href="<?php echo base_url("project/add?project=1&customer=$student_id")?>"><i class="fa fa-plus"></i>Add</a>
                        <a href="<?php echo base_url("project/edit/".$enroll->order_id.'?project=1');?>" class="link_edit"><i class="fa fa-edit"></i>Edit</a>
                            </div>
                        </div>
                        <ul>
                            <?php
                                $next_phase = $latest_phase + 1
                            ?>
                            <li class="<?php echo $phase == 1 ? 'active' : '';?> <?php echo $next_phase > 1 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 1 ? base_url("project/case/$student_id/$enroll_id") : 'javascript:void();';?>" >Case <br>start</a></li>
                            <li class="<?php echo $phase == 2 ? 'active' : '';?>  <?php echo $next_phase > 2 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 2 ? base_url("project/case/$student_id/$enroll_id/2") : 'javascript:void();';?>" >Contract <br> signed</a></li>
                            <?php 
                            if($enroll->visa == 14){
                                ?>
                                 <li class="<?php echo $phase == 3 ? 'active' : '';?>  <?php echo $next_phase > 3 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 3 ? base_url("project/case/$student_id/$enroll_id/3") : 'javascript:void();';?>">Offer letter <br>processing</a></li>
                                <li class="<?php echo $phase == 4 ? 'active' : '';?>  <?php echo $next_phase > 4 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 4 ? base_url("project/case/$student_id/$enroll_id/4") : 'javascript:void();';?>">Offer letter <br> issued</a></li>
                                <li class="<?php echo $phase == 5 ? 'active' : '';?>  <?php echo $next_phase > 5 && $phase5->is_skipped != 1 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 5 ? base_url("project/case/$student_id/$enroll_id/5") : 'javascript:void();';?>">Coe <br>Processing</a></li>
                                <li class="<?php echo $phase == 6 ? 'active' : '';?>  <?php echo $next_phase > 6 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 6 ? base_url("project/case/$student_id/$enroll_id/6") : 'javascript:void();';?>">Coe <br> issued</a></li>
                                <li class="<?php echo $phase == 7 ? 'active' : '';?>  <?php echo $next_phase > 7 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 7 ? base_url("project/case/$student_id/$enroll_id/7") : 'javascript:void();';?>">Enrolled<br>&nbsp;</a></li>
                                <?php
                            }else{
                                ?>
                                 <li class="<?php echo $phase == 3 ? 'active' : '';?>  <?php echo $next_phase > 3 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 3 ? base_url("project/case/$student_id/$enroll_id/3") : 'javascript:void();';?>">Document<br> List</a></li>
                                <li class="<?php echo $phase == 4 ? 'active' : '';?>  <?php echo $next_phase > 4 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 4 ? base_url("project/case/$student_id/$enroll_id/4") : 'javascript:void();';?>">Document<br> Received</a></li>
                                <li class="<?php echo $phase == 5 ? 'active' : '';?>  <?php echo $next_phase > 5 && $phase5->is_skipped != 1 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 5 ? base_url("project/case/$student_id/$enroll_id/5") : 'javascript:void();';?>">Application<br> Prepared</a></li>
                                <li class="<?php echo $phase == 6 ? 'active' : '';?>  <?php echo $next_phase > 6 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 6 ? base_url("project/case/$student_id/$enroll_id/6") : 'javascript:void();';?>">Supervisor<br> Checked</a></li>
                                <li class="<?php echo $phase == 7 ? 'active' : '';?>  <?php echo $next_phase > 7 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 7 ? base_url("project/case/$student_id/$enroll_id/7") : 'javascript:void();';?>">Application <br> lodged</a></li>
                                <li class="<?php echo $phase == 8 ? 'active' : '';?>  <?php echo $next_phase > 8 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 8 ? base_url("project/case/$student_id/$enroll_id/8") : 'javascript:void();';?>">Application <br>acknowledged</a></li>
                                <li class="<?php echo $phase == 9 ? 'active' : '';?>  <?php echo $next_phase > 9 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 9 ? base_url("project/case/$student_id/$enroll_id/9") : 'javascript:void();';?>">Document<br> lodged</a></li>
                                <li class="<?php echo $phase == 10 ? 'active' : '';?>  <?php echo $next_phase > 10 ? 'approved' : '';?>"><a href="<?php echo $next_phase >= 10 ? base_url("project/case/$student_id/$enroll_id/10") : 'javascript:void();';?>">Processing<br> commenced</a></li>
                                <?php
                            }
                            ?>
                           
                        </ul>
                    </div>
                        <div>
                            <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                            <input type="hidden" name="enroll_id" id="enroll_id" value="<?php echo $enroll_id;?>">
                            <input type="hidden" id="phase_id" name="phase_id" value="<?php echo $phase;?>">
                        </div>
                    <?php
                       $this->load->view($case);
                            
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>

</section>
</div>


</section>