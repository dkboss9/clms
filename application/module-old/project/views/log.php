
<?php if(count($logs) > 0) { ?>

    <section class="card phase_logs">
        <header class="card-header card-header-transparent">
            <div class="card-actions">
                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
            </div>

            <h2 class="card-title">Case logs</h2>
        </header>
        <div class="card-body">
            <div class="timeline timeline-simple mt-3 mb-3">
                <div class="tm-body">
                    <!-- <div class="tm-title">
                        <h5 class="m-0 pt-2 pb-2 text-uppercase">November 2017</h5>
                    </div> -->
                    <ol class="tm-items">
                        <?php 
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
                     <?php } ?>
                    </ol>
                </div>
            </div>
        </div>
    </section>

<?php } ?>