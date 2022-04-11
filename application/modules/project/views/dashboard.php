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
                                <?php   $companylist = $this->projectmodel->chatmsglist(); ?>
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
                                                                    href="<?php echo base_url("project/chatmsglist/$student_id");?>"><?php echo count($companylist);?></a></strong>
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
                                                    <i class="fa fa-usd" aria-hidden="true"></i>
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