<style>
    .modal-footer {
        margin-top: 0 !important;
    }
    .span_date{
        font-size: 20px;
    }

    .date_title_child a{
        font-size: 20px;
    }

    .service-time{
        font-size: 10px;
    }
</style>
<!-- start: page -->
<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
            <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Check In</h2>
    </header>

    <div class="panel-body">
        <?php if($this->session->flashdata("success_message")){?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?>
        </div>
        <?php
  }
  ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-md">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div class="date_title">
                                    <div class="date_title_child week">
                                        <a
                                            href="<?php echo base_url("check_in/listall?sdate=".$prev_start_date."&edate=".$prev_end_date."&date=".$prev_start_date)?>">
                                            <i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                                        <span class="span_date"><?php echo date('l, jS F Y',strtotime($periods[0]));?> -
                                            <?php echo date('l, jS F Y',strtotime($periods[6])); ?></span>
                                        <a
                                            href="<?php echo base_url("check_in/listall?sdate=".$next_start_date."&edate=".$next_end_date."&date=".$next_start_date)?>"><i
                                                class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>
                                    <div class="date_title_child default_date">

                                    </div>
                                </div>
                                <div class="table-responsive" style="padding-top: 20px;">
                                    <table border="0" cellspacing="0" cellpadding="0"
                                        class="table table-hover display table_pmdoc   pb-10">
                                        <tbody>
                                            <tr style="background: #47a447;">
                                                <?php
                           foreach($periods as $key=>$period){
                             $color = $period == $default_date ? 'font-weight: bold;background: #ddd;' : 'font-weight: bold;';
                            ?>
                                                <th align="left" valign="top" style="<?php echo $color; ?>">
                                                    <a href="<?php echo base_url("check_in/listall?date=".$period."&sdate=".date("Y-m-d",strtotime("+1 day",strtotime($prev_end_date)))."&edate=".date("Y-m-d",strtotime("+7 day",strtotime($prev_end_date))));?>"
                                                        style="color:#ffffff;">
                                                        <?php echo date('D, jS M Y',strtotime($period));?>
                                                    </a>
                                                </th>
                                                <?php } ?>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>

                                <table class="table table-bordered table-striped mb-none" id="datatable-default">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;">Sn</th>
                                            <th >Employee Name</th>
                                            <th>Check In Time</th>
                                            <th >Check In </th>
                                            <th >Check Out Time</th>
                                            <th >Check Out </th>
                                            <th width="30%">Daily Standup</th>
                                            <th width="30%">Updates </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
      foreach ($users as $key => $user) {
        $this->db->where("user_id",$user->id);
        $this->db->where("register_date", $default_date);
        $attendence = $this->db->get("employee_daily_activity")->row();

       
        $this->db->where("user_id",$user->id);
        $installer = $this->db->get("installer")->row();

        $day =  date("N",strtotime($default_date));

        $result = $this->check_inmodel->get_service_time($day,$user->id);
        if($result->num_rows() == 0){
            $service = 0;
        }else{
            $row = $result->row();
            if($row->service_start_time == '00:00:00')
            $service = 0;
            else
            $service = 1;
        }
       

        $css = $service == 0 ? 'style="background:#fff0f0;"' : '';
      
        
       ?>
                                        <tr class="gradeX" <?php echo $css; ?> >
                                            <td><?php echo ++$key;?></td>
                                            <td>
                                                <?php echo $user->first_name;?> <?php echo $user->last_name;?>
                                                <br> 
                                                <?php 
                                                 if($service == 1) echo '<span class="service-time">('.date("h:i a",strtotime($row->service_start_time)) .' to '.date("h:i a",strtotime($row->service_end_time)).')</span>';
                                                ?>
                                            </td>
                                            <td><?php echo isset($attendence->checkin_at) ? date("h:i a",strtotime($attendence->checkin_at)):'';?></td>
                                            <td> <a href="javascript:void(0);"
                                            <?php if($alldata == 0 && (isset($attendence->checkin_at) || $default_date != date("Y-m-d"))) echo 'disabled' ?>
                                                    class="mb-xs mt-xs mr-xs btn btn-primary link_checkIn"
                                                    userid="<?php echo $user->id;?>"
                                                    date="<?php echo date('D, jS M Y',strtotime($default_date));?>"
                                                    data-toggle="modal" data-target="#checkINModal" 
                                                    time="<?php echo isset($attendence->checkin_at) ? date("H:i",strtotime($attendence->checkin_at)):'';?>"
                                                     content="<?php echo isset($attendence->checkin_note) ? $attendence->checkin_note:'';?>"><i
                                                        class="fa fa-clock-o" aria-hidden="true"></i></a></td>
                                            
                                            <td><?php echo isset($attendence->checkout_at) ? date("h:i a",strtotime($attendence->checkout_at)):'';?></td>
                                            <td> <a href="javascript:void(0);"
                                            <?php if(($alldata == 0 && $default_date != date("Y-m-d")) || !isset($attendence->checkin_at)) echo 'disabled' ?>
                                                    class="mb-xs mt-xs mr-xs btn btn-success link_checkout"
                                                    userid="<?php echo $user->id;?>"
                                                    time="<?php echo isset($attendence->checkout_at) ? date("H:i",strtotime($attendence->checkout_at)):'';?>"
                                                    checkout_content="<?php echo isset($attendence->checkout_note) ? $attendence->checkout_note:'';?>"
                                                    date="<?php echo date('D, jS M Y',strtotime($default_date));?>"
                                                  
                                                    data-toggle="modal" data-target="#checkOutModal">
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                </a></td>
                                            <td><?php echo isset($attendence->checkin_note) ? nl2br($attendence->checkin_note):'';?></td>
                                            <td><?php echo isset($attendence->checkout_note) ? nl2br($attendence->checkout_note):'';?></td>
                                        </tr>
                                        <?php
    } ?>


                                    </tbody>
                                </table>
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

<div class="modal fade" id="checkINModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkInTitle">Modal title</h5>
            </div>
            <form name="form_checkin" id="form_checkin" method="post" action="<?php echo base_url("check_in/add")?>">

                <div class="modal-body">
                <?php if($alldata > 0) { ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Reminder Time</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <input type="text" data-plugin-timepicker="" value="" name="time" id="time" autocomplete="off"
                                 class="form-control required"
                                    data-plugin-options="{ &quot;showMeridian&quot;: false }" >
                            </div>
                        </div>
                    </div>
                <?php } ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Note: </label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="checkInNote" id="checkInNote" rows="10" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="userid" id="userid" value="" />
                    <input type="hidden" name="date" value="<?php echo $default_date;?>" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add stand up</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="checkOutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkOutTitle">Modal title</h5>

            </div>
            <form name="form_checkout" id="form_checkout" method="post" action="<?php echo base_url("check_in/edit")?>">
               
           
                <div class="modal-body">
                <?php if($alldata > 0) { ?>
                <div class="form-group">
                    <label class="col-md-3 control-label">Reminder Time</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </span>
                            <input required type="text" data-plugin-timepicker="" value="" name="checkout_time" id="checkout_time" class="form-control" autocomplete="off"
                                data-plugin-options="{ &quot;showMeridian&quot;: false }">
                        </div>
                    </div>
                </div>
            <?php } ?>
                <div class="form-group">
                        <label class="col-md-3 control-label">Note: </label>
                        <div class="col-md-9">
                        <textarea class="form-control" name="checkOutNote" id="checkOutNote" rows="10"
                        required><?php echo @$row->checkout_note;?></textarea>
                        </div>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label class="col-md-9 control-label">Push Code on Gitlab ? : 
                            <input  type="checkbox" name="is_pushed" id="is_pushed" value="1"  class=""> </label>
                    </div>
                  
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="userid" id="checkout_userid" value="" />
                    <input type="hidden" name="date" value="<?php echo $default_date;?>" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#form_checkin").validate();
        $("#form_checkout").validate();
        $(".link_checkIn").click(function () {
            var date = $(this).attr("date");
            var userid = $(this).attr("userid")
            $("#checkInTitle").html('CHECK IN:- ' + date);
            $("#userid").val(userid);
            $("#time").val($(this).attr("time"));
            $("#checkInNote").html($(this).attr("content"));
        });

        $(".link_checkout").click(function () {
            var date = $(this).attr("date");
            var userid = $(this).attr("userid");
            var content = $(this).attr("checkout_content");
            var is_push_required = $(this).attr("is_push_required");
            if(is_push_required > 0){
                $("#is_pushed").addClass("required");
            }
            $("#checkOutTitle").html('CHECK OUT:- ' + date);
            $("#checkout_userid").val(userid);
            $("#checkout_time").val($(this).attr("time"));
            $("#checkOutNote").html(content);
        });
        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'bottom'
        });
        $('#addButton').bind('click', function () {
            window.location.assign("<?php echo base_url() ?>visit/add");
        })
        $("#checkall").click(function () {
            $(".checkone").prop('checked', $(this).prop('checked'));
        });
        $(".link_delete").click(function () {
            if (!confirm('Are you sure to delete this Lead?'))
                return false;
        });
    });
</script>