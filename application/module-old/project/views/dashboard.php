<!-- start: page -->
<style>
    .info a {
        color: #000000;
    }
</style>
<section class="panel">
    <div class="panel-body case-body">

        <?php $this->load->view("tab");?>
        <div class="migrate-menu">
            <div class="row">
                <div class="col-sm-12">
                    <div class="migrate-menu-list">
                        <div class="mig-top-sec">
                            <!-- <h4 class="mitgrate-tt">Dashboard</h4> -->
                            <div class="adding">
                                <!-- <a href="javascript:void();"><i class="fa fa-plus"></i>Add</a>
                                <a href="javascript:void();"><i class="fa fa-edit"></i>Edit</a> -->
                            </div>
                        </div>

                    </div>
                    <div>
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                    </div>
                    <?php echo $this->load->view("dashboard_count");?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row mb-6">
                                <div class="col-lg-4 col-xl-4">
                                    <section class="card card-featured-left card-featured-quaternary">
                                        <div class="card-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-tertiary">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Cases</h4>
                                                        <div class="info">
                                                            <strong class="amount"><a
                                                                    href="<?php echo base_url("project/cases/$student_id");?>"><?php echo $enrolls->num_rows();?></a></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <!-- <a class="text-muted text-uppercase" href="#">(report)</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <section class="card card-featured-left card-featured-primary mb-3">
                                        <div class="card-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-primary">
                                                        <i class="fa fa-bars"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Collected Points</h4>
                                                        <div class="info">
                                                            <strong class="amount"><a
                                                                    href="<?php echo base_url("project/points/$student_id");?>"><?php echo $point->points;?></a></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <!-- <a class="text-muted text-uppercase" href="#">(view all)</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <section class="card card-featured-left card-featured-secondary">
                                        <div class="card-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-secondary">
                                                        <i class="fa fa-comment"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Notes</h4>
                                                        <div class="info">
                                                            <strong class="amount"><a
                                                                    href="<?php echo base_url("project/notes/$student_id");?>"><?php echo count($messages);?></a></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <!-- <a class="text-muted text-uppercase" href="#">(withdraw)</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-xl-4">
                                    <section class="card card-featured-left card-featured-secondary">
                                        <div class="card-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-secondary">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Invoices</h4>
                                                        <div class="info">
                                                            <strong class="amount"><a
                                                                    href="<?php echo base_url("project/invoice/$student_id");?>"><?php echo sprintf('%0.2f', round($order->total, 2));?></a></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <!-- <a class="text-muted text-uppercase" href="#">(withdraw)</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <section class="card card-featured-left card-featured-tertiary mb-3">
                                        <div class="card-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-tertiary">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Total Appointments</h4>
                                                        <div class="info">
                                                            <strong class="amount"><a
                                                                    href="<?php echo base_url("project/appointments/$student_id");?>"><?php echo $appointments->num_rows();?></a></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <!-- <a class="text-muted text-uppercase" href="#">(statement)</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <section class="card card-featured-left card-featured-quaternary">
                                        <div class="card-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-tertiary">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Active Appointments</h4>
                                                        <div class="info">
                                                            <strong class="amount"><a
                                                                    href="<?php echo base_url("project/appointments/$student_id?appointment_date=active");?>"
                                                                    style="color:green;"><?php echo $active_appointments->num_rows();?></a></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <!-- <a class="text-muted text-uppercase" href="#">(statement)</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>

                            <div class="row student-log">
                                <div class="col-lg-4 col-xl-4">
                                    <section class="card card-transparent">
                                        <header class="card-header">
                                            <h2 class="card-title"><strong>Checklist</strong></h2>
                                        </header>
                                        <div class="card-body">
                                            <section class="card card-group">
                                                <div id="accordion" class="w-100">
                                                    <div class="card card-accordion card-accordion-first">
                                                        <div id="collapse1One" class="accordion-body  show">
                                                            <div class="card-body">
                                                                <ul class="widget-todo-list">
                                                                    <?php
                                                                foreach($enrolls->result() as $enroll){
                                                                if($enroll->visa == 28){
                                                                  foreach ($docs as $row) {
                                                                    $enroll_check = $this->projectmodel->checkChecklist($row->type_id,$enroll->order_id)->row();
                                                                    $user = $this->projectmodel->getUserDetail(@$enroll_check->added_by);
                                                                    ?>
                                                                    <li>
                                                                        <div class="checkbox-custom checkbox-default">
                                                                            <input type="checkbox" checked=""
                                                                                id="todoListItem1" class="todo-check"
                                                                                <?php echo @$enroll_check->is_approved == 1 ? 'checked':''; ?> disabled>
                                                                            <label class="" for="todoListItem1"><span>
                                                                                    <?php echo $row->type_name;?></span></label>
                                                                        </div>

                                                                    </li>
                                                                    <?php }
                                                                        }else{
                                                                                ?>

                                                                    <?php
   $checklists = $this->appointmentmodel->listChecklist($enroll->fee_id);
   
   foreach ($checklists->result() as $row) {
    $enroll_check = $this->projectmodel->checkChecklist($row->type_id,$enroll->order_id)->row();
   
    ?>
                                                                    <li>
                                                                        <div class="checkbox-custom checkbox-default">
                                                                            <input type="checkbox" checked=""
                                                                                id="todoListItem1" class="todo-check"
                                                                                <?php echo @$enroll_check->is_approved == 1 ? 'checked':''; ?> disabled>
                                                                            <label class="" for="todoListItem1"><span>
                                                                                    <?php echo $row->type_name;?></span></label>
                                                                        </div>

                                                                    </li>

                                                                    <?php
                                                                            }

                                                                            $checklists = $this->appointmentmodel->listChecklist($enroll->fee_id);
   
                                                                            foreach ($checklists->result() as $row) {
                                                                             $enroll_check = $this->projectmodel->checkChecklist($row->type_id,$enroll->order_id)->row();
                                                                            
                                                                             ?>
                                                                    <li>
                                                                        <div class="checkbox-custom checkbox-default">
                                                                            <input type="checkbox" checked=""
                                                                                id="todoListItem1" class="todo-check"
                                                                                <?php echo @$enroll_check->is_approved == 1 ? 'checked':''; ?> disabled>
                                                                            <label class="" for="todoListItem1"><span>
                                                                                    <?php echo $row->type_name;?></span></label>
                                                                        </div>

                                                                    </li>

                                                                    <?php
                                                                                                                                                     }
                                                                           
                                                                        }
                                                                    } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </section>

                                        </div>
                                    </section>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <section class="card card-transparent">
                                        <header class="card-header">
                                            <h2 class="card-title"><strong>Notice Board </strong></h2>
                                        </header>
                                        <div class="card-body">
                                            <section class="card card-group notice-board">
                                                <div id="accordion" class="w-100">
                                                    <div class="card card-accordion card-accordion-first">
                                                        <div id="collapse1One" class="accordion-body  show">
                                                            <div class="card-body">
                                                                <ul class="widget-todo-list">
                                                                <?php foreach($messages as $msg){ ?>
                                                        <li style="clear:both;">
                                                            <div class="tm-box <?php echo $msg->added_by == $this->session->userdata("clms_front_userid") ? "customer_note":"student_note";?>">
                                                                <p class="text-muted mb-0"><?php echo date("d F, Y",strtotime($msg->added_at));?> at <?php echo date("h:i a",strtotime($msg->added_at));?> By <?php echo $msg->first_name;?> <?php echo $msg->last_name;?></p>
                                                             <?php
                                                             if($msg->comment){
                                                             ?>
                                                                <p>
                                                                    <?php echo $msg->comment;?>
                                                                </p>
                                                                <?php } ?>
                                                                <?php if($msg->file_name){ ?>
                                                                <p><span class="text-primary">
                                                                <a href="<?php echo SITE_URL."uploads/document/$msg->file_name";?>" target="_blank" ><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                                                </span>
                                                                </p>
                                                                <?php } ?>
                                                            </div>
                                                        
                                                        </li>
                                                    <?php } ?>
                                                                  

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </section>

                                        </div>
                                    </section>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <section class="card card-transparent">
                                        <header class="card-header">
                                            <h2 class="card-title"><strong>Activity Logs</strong></h2>
                                        </header>
                                        <div class="card-body">
                                            <section class="card card-group notice-board">
                                                <div id="accordion" class="w-100">
                                                    <div class="card card-accordion card-accordion-first">
                                                        <div id="collapse1One" class="accordion-body  show">
                                                            <div class="card-body">
                                                                <ul class="widget-todo-list activiy-logs">
                                                                    <?php 
                                                                      foreach($enrolls->result() as $enroll){
                                                                        $logs = $this->projectmodel->checkphase($enroll->enroll_id,null,1);
                                                                        foreach($logs as $log){
                                                                    ?>
                                                                    <li>
                                                                        <div class="tm-box">
                                                                            <p class="text-muted mb-0"><strong><?php echo $enroll->visa == 14 ? get_enroll_education_phase($log->case_phase) : get_enroll_phase($log->case_phase);?>: </strong><?php echo date("d F, Y h:i a",strtotime($log->date));?> By <?php echo $log->first_name;?> <?php echo $log->last_name;?></p>
                                                                            <p><span class="text-primary">Admin note:</span>
                                                                            <?php echo $log->admin_note; ?>
                                                                            </p>
                                                                            <p><span class="text-primary">Customer note:</span>
                                                                            <?php echo $log->customer_note; ?>
                                                                            </p>
                                                                            <?php if($log->file_name){ ?>
                                                                            <p><span class="text-primary">
                                                                            <a href="<?php echo SITE_URL."uploads/document/$log->file_name";?>" target="_blank" ><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                                                            </span>
                                                                            </p>
                                                                            <?php } ?>
                                                                        </div>

                                                                    </li>
                                                                <?php } } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </section>

                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</section>
</div>


</section>