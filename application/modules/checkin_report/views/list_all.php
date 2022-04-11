<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url("");?>assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#details123').trumbowyg();
    });
</script>


<?php 
if($this->session->flashdata("success_message"))
{
  ?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message");?>
</div>
<?php
}
?>

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
                    <table class="table table-bordered table-striped mb-none" id="datatable-default1">
                        <thead>
                            <tr>
                                <th>Sn</th>
                                <th>Name</th>
                                <th > Date</th>
                                <th >Check In Time</th>
                                <th >Check Out Time</th>
                                <th width="30%">Daily Standup</th>
                                <th width="30%">Updates </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                            foreach($attendences as $key => $row){
                                                ?>
                            <tr>
                                <td> <?php echo ++$key;?></td>
                                <td> <?php echo $row->first_name;?> <?php echo $row->last_name;?> </td>
                                <td><?php echo date("d-m-Y",strtotime($row->register_date));?></td>
                                <td><?php echo $row->checkin_at ? date("h:i a",strtotime($row->checkin_at)) : '';?></td>
                                <td><?php echo $row->checkout_at ? date("h:i a",strtotime($row->checkout_at)):'';?></td>
                                <td><?php echo nl2br($row->checkin_note);?></td>
                                <td><?php echo nl2br($row->checkout_note);?></td>
                            </tr>
                            <?php 
                                            }
                                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

</section>
</div>
</section>

<script type="text/javascript">
    $(document).ready(function () {

        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy'
        });

        $("#period_custom").click(function () {
            if ($(this).prop("checked"))
                period_custom();
            else
                period_monthly();
        });

        function period_custom() {
            $(".div_monthly").hide();
            $(".div_custom").show();
            $(".div_activity").hide();
        }

        function period_monthly() {
            $(".div_monthly").show();
            $(".div_custom").hide();
            $(".div_activity").hide();
        }

     
    });

    function printDiv() 
{

  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>