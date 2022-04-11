
<div class="row">
    <div class="col-md-12">
        <div class="tabs tabs-warning">


            <div class="tab-content">
                <div id="leads" class="tab-pane <?php if(!$this->input->get("tab")) echo 'active';?>">
                    <form name="account_statement" id="account_statement" method="get"
                        action="<?php echo current_url();?>">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="mb-md">
                                    <label>Staffs </label>
                                    <select name="staff" id="staff" data-plugin-selectTwo class="form-control">
                                        <option value="" <?php //echo $customer == 'all' ? 'selected="selected"':'';?>>
                                            All</option>
                                        <?php 
                        foreach($users as $user){
                            ?>
                                        <option value="<?php echo $user->id;?>"
                                            <?php echo $staff == $user->id ? 'selected="selected"':'';?>>
                                            <?php echo $user->first_name;?> <?php echo $user->last_name;?></option>
                                        <?php
                        }
                 ?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="mb-md">
                                    <p>Date </p>
                                    <input type="checkbox" name="period" id="period_custom" value="1"
                                        <?php echo $period == '1' ? 'checked="checked"':'';?>><label>
                                        Custom</label> &nbsp;
                                </div>
                            </div>
                            <div class="col-sm-2 div_monthly" <?php if($period == '1') echo 'style="display: none"';?>>
                                <div class="mb-md">
                                    <label>Month</label>
                                    <select name="date" id="date" data-plugin-selectTwo class="form-control">
                                        <option value="all" <?php if($date == 'all') echo 'selected';?>>All</option>
                                        <option value="today" <?php if($date == 'today') echo 'selected';?>>Today
                                        </option>
                                        <option value="week" <?php if($date == 'week') echo 'selected';?>>Weekly
                                        </option>
                                        <option value="month" <?php if($date == 'month') echo 'selected';?>>Monthly
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-2 div_custom" <?php if($period == '') echo 'style="display: none"';?>>
                                <div class="mb-md">
                                    <label>From Date</label>
                                    <input type="text" name="activity_from_date" class="form-control datepicker"
                                        value="<?php echo $activity_from_date;?>" autocomplete="off">

                                </div>
                            </div>

                            <div class="col-sm-2 div_custom" <?php if($period == '') echo 'style="display: none"';?>>
                                <div class="mb-md">
                                    <label>To Date</label>
                                    <input type="text" name="activity_to_date" class="form-control datepicker"
                                        value="<?php echo $activity_to_date;?>" autocomplete="off">

                                </div>
                            </div>

                            <div class="col-sm-2 ">
                                <div class="mb-md" style="padding-top: 21px;">
                                <input type="hidden" name="fm" value="1">
                                    <input type="submit" name="submit" value="Search"
                                        class="mb-xs mt-xs mr-xs btn btn-primary">
                                </div>
                            </div>

                            <div class="col-sm-4 ">
                            <a href="<?php echo base_url("checkin_report/export?".$get_url);?>"
                                        class="mb-xs mt-xs mr-xs btn btn-primary">
                                        <i class="fa fa-download" aria-hidden="true"></i> Export CSV
                            </a>

                            <a href="<?php echo base_url("checkin_report/pdf?".$get_url);?>"
                                        class="mb-xs mt-xs mr-xs btn btn-primary">
                                        <i class="fa fa-download" aria-hidden="true"></i> Export PDF
                            </a>

                            <a href="javascript:void();"
                                        class="mb-xs mt-xs mr-xs btn btn-primary"
                                        onclick='printDiv();'>
                                        <i class="fa fa-print" aria-hidden="true"></i>  Print
                            </a>
                            </div>

                        </div>
                    </form>
                    <hr>
                    <div id="DivIdToPrint">
                
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

</section>
</div>
</section>

