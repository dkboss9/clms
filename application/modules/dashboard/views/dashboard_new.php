
<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<?php
function createDateRangeArray($strDateFrom,$strDateTo)
{

  $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

  if ($iDateTo>=$iDateFrom)
  {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
          }
        }
        return $aryRange;
      }
      $caldate = array();
      foreach ($callender_tasks as $cal) {
        $start_date = $cal->start_date;
        $end_date = $cal->end_date;
        if($start_date <= $end_date){
          $task_dates = createDateRangeArray( date('Y-m-d',$start_date), date('Y-m-d',$end_date) );
          foreach ($task_dates as $key => $value) {
            array_push($caldate,date('j/n/Y',strtotime($value)));
          }
        } 
      } 
      
      foreach ($callender_leads as $lead) {
        array_push($caldate,date('j/n/Y',$lead->reminder_date));
      }
      
      $caldate = array_unique($caldate);
     // print_r($caldate);
      $string = '[';
      foreach ($caldate as $key => $value) {
        $string.='"'.$value.'",';
      }
      $string = rtrim($string, ",");
      $string.=']';
      //echo $string;
      ?>
      <script type="text/javascript">
        var active_dates = <?php echo $string;?>;
        console.log(active_dates);
        $(document).ready(function(){

          $('#trumbowyg').trumbowyg();
         
          $("#datepicker").datepicker({
           format: "dd/mm/yyyy",
           autoclose: true,
           todayHighlight: true,
           beforeShowDay: function(date){
             var d = date;
             var curr_date = d.getDate();
         var curr_month = d.getMonth() + 1; //Months are zero based
         var curr_year = d.getFullYear();
         var formattedDate = curr_date + "/" + curr_month + "/" + curr_year

         if ($.inArray(formattedDate, active_dates) != -1){
           return {
            classes: 'activeClass'
          };
        }
        return;
      }
    });
        });
      </script>
      <style>
       .activeClass{
         background-color: #d14836;
       }
     </style>
     <section role="main" class="content-body">
       <header class="page-header">
        <h2>Effective Lead Management System</h2>
        <div class="right-wrapper pull-right">
          <a class="sidebar-right-toggle" href="<?php echo base_url("logout");?>"><i class="fa fa-power-off"></i></a>
        </div>

      </header>
      <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message") ?>
      </div>
      <?php
    }
    ?>
    <!-- start: page -->
    <div class="row">

      <div class="col-lg-6 col-md-12">
        <section class="panel">
          <header class="panel-heading panel-heading-transparent">
            <div class="panel-actions">
              <a href="#" class="" data-panel-toggle></a>
              <a href="#" class="" data-panel-dismiss></a>
            </div>

            <h2 class="panel-title">Today's Reminder  
              <?php if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkpermDashboard("LEAD-MANAGEMENT","ADD")) {?>
              <a class="popup-with-form " href="#lead-form"><i class="glyphicon glyphicon-plus-sign"></i></a>
              <?php } ?></h2>

            </header>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped mb-none">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Project</th>
                      <th>Status</th>
                      <th>Sale Reps</th>
                      <th>Phone Number</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    date_default_timezone_set('Australia/Sydney');
                //echo date("Y-m-d h:i:s");
                    $todays = $this->dashboardmodel->get_todayLeads();
                    $i = 1;
                    if(count($todays)>0){
                      foreach ($todays as $lead) {
                        $status = $this->dashboardmodel->get_leadstatus($lead->status_id);
                        if($lead->status_id == 1)
                          $class = 'label-warning';
                        elseif($lead->status_id == 4)
                          $class = 'label-danger';
                        else
                          $class = 'label-success';
                        ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><a class="simple-ajax-popup btn-default"   href="<?php echo base_url("lms/detail/".$lead->lead_id);?>"><?php echo $lead->lead_name;?></a></td>
                          <td><span class="label <?php echo $class;?>"><?php echo @$status->status_name;?></span></td>
                          <td>
                            <?php  echo $lead->first_name != "" ? $lead->first_name.' '.$lead->last_name : 'N/A';?>
                          </td>
                          <td>
                            <?php  echo $lead->phone_number;?>
                          </td>
                        </tr>
                        <?php
                        $i++;
                      }}else{
                        ?>
                        <tr>
                          <td colspan="4">No Data found.</td>
                        </tr>
                        <?php
                      }
                      ?>


                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
          <div class="col-lg-6 col-md-12">
            <section class="panel">
              <header class="panel-heading panel-heading-transparent">
                <div class="panel-actions">
                  <a href="#" class="" data-panel-toggle></a>
                  <a href="#" class="" data-panel-dismiss></a>
                </div>

                <h2 class="panel-title">Reminder Exceed</h2>
              </header>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped mb-none">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Sale Reps</th>
                        <th>Phone Number</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $leads = $this->dashboardmodel->get_yesterdayLeads();
                      $i = 1;
                      if(count($leads)>0){
                        foreach ($leads as $lead) {
                          $status = $this->dashboardmodel->get_leadstatus($lead->status_id);
                          if($lead->status_id == 1)
                            $class = 'label-warning';
                          elseif($lead->status_id == 4)
                            $class = 'label-danger';
                          else
                            $class = 'label-success';
                          ?>
                          <tr>
                            <td><?php echo $i;?> </td>
                            <td><a class="simple-ajax-popup btn-default"   href="<?php echo base_url("lms/detail/".$lead->lead_id);?>"><?php echo $lead->lead_name;?></a></td>
                            <td><span class="label <?php echo $class;?>"><?php echo @$status->status_name;?></span></td>
                            <td>
                             <?php  echo $lead->first_name != "" ? $lead->first_name.' '.$lead->last_name : 'N/A';?>
                           </td>
                           <td>
                            <?php  echo $lead->phone_number;?>
                          </td>
                        </tr>
                        <?php
                        $i++;
                      }}else{
                        ?>
                        <tr>
                          <td colspan="4">No Data found.</td>
                        </tr>
                        <?php
                      }
                      ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-12 col-xl-6">
            <section class="panel">
              <div class="panel-body">
                <div class="row">
                 <div class="col-lg-6">
                   <form action="<?php echo base_url("dashboard/chat");?>" method="post">
                     <div class="form-group">
                       <div class="col-md-10">
                         <textarea name="txt_msg" class="form-control"></textarea>
                       </div>
                       <label class="col-md-2 control-label" for="inputDefault"> 
                        <input type="submit" name="btn-submit" value="Submit" class="btn btn-primary">
                      </label>

                    </div>
                  </form>
                </br>
                <div style="height:180px;overflow:scroll;">
                 <?php 
                 foreach ($notes as $row) {
                  if($this->session->userdata("clms_front_userid") == $row->userid)
                    echo '<p>'.$row->user_name.': '.$row->content.' <a href="'.base_url("dashboard/delete_chat/".$row->note_id).'" class="link_delete"><span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a></p>';
                  else
                    echo '<p>'.$row->user_name.': '.$row->content.'</p>';
                }
                ?>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="chart-data-selector ready" id="salesSelectorWrapper">

               <div id="datepicker"></div>

             </div>
           </div>
           <div class="col-lg-2">
             <a href="<?php echo base_url("events/listall");?>" title="Events"><img src="<?php echo base_url("assets/images/calendar.png");?>" width="100" height="100"></a>
           </div>
         </div>
       </div>
     </section>
   </div>
   <!-- notifications -->
   <div class="col-md-6 col-lg-12 col-xl-6">
    <div class="row">
      <div class="col-md-12 col-lg-6 col-xl-6">
        <section class="panel panel-featured-left panel-featured-primary">
          <div class="panel-body">
            <div class="widget-summary">
              <div class="widget-summary-col widget-summary-col-icon">
                <div class="summary-icon bg-primary">
                  <i class="fa fa-life-ring"></i>
                </div>
              </div>
              <div class="widget-summary-col">
                <div class="summary">
                 <?php
                 $lead_types = $this->dashboardmodel->listallLeadType();
                 foreach ($lead_types->result() as $row) {
                  $num = $this->dashboardmodel->count_leads($row->cat_id);
                  echo '<h4 class="title">'.$row->cat_name.': <a href="'.base_url("lms/listall?category=".$row->cat_id).'">'.$num.'</a></h4>';
                }
                ?>


              </div>
              <div class="summary-footer">
                <a class="text-muted text-uppercase">(view all)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-md-12 col-lg-6 col-xl-6">
      <section class="panel panel-featured-left panel-featured-secondary">
        <div class="panel-body">
          <div class="widget-summary">
            <div class="widget-summary-col widget-summary-col-icon">
              <div class="summary-icon bg-secondary">
                <i class="fa fa-usd"></i>
              </div>
            </div>
            <div class="widget-summary-col">
              <div class="summary">
                <?php
               // $todays = $this->dashboardmodel->get_todayLeads(strtotime(date("Y-m-d")));
                $num = $this->dashboardmodel->count_todayLead();
                echo '<h4 class="title">Today Leads: <a href="'.base_url("lms/listall?lead_date=today").'">'.$num.'</a></h4>';
                $num = $this->dashboardmodel->count_yesterdayLead();
                echo '<h4 class="title">Yesterday Leads: <a href="'.base_url("lms/listall?lead_date=yesterday").'">'.$num.'</a></h4>';
                $num = $this->dashboardmodel->count_weekLead();
                echo '<h4 class="title">This Week: <a href="'.base_url("lms/listall?lead_date=week").'">'.$num.'</a></h4>';
                $num = $this->dashboardmodel->count_monthLead();
                echo '<h4 class="title">This Month: <a href="'.base_url("lms/listall?lead_date=month").'">'.$num.'</a></h4>';
                ?>


              </div>
              <div class="summary-footer">
                <a class="text-muted text-uppercase">(view all)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-md-12 col-lg-6 col-xl-6">
      <section class="panel panel-featured-left panel-featured-tertiary">
        <div class="panel-body">
          <div class="widget-summary">
            <div class="widget-summary-col widget-summary-col-icon">
              <div class="summary-icon bg-tertiary">
                <i class="fa fa-shopping-cart"></i>
              </div>
            </div>
            <div class="widget-summary-col">
              <div class="summary">
                <?php
                //$todays = $this->dashboardmodel->count_todayAddedLead(strtotime(date("Y-m-d")));
                $num = $this->dashboardmodel->count_todayAddedLead();
                echo '<h4 class="title">Today added Leads: <a href="'.base_url("lms/listall?added_date=today").'">'.$num.'</a></h4>';
                $num = $this->dashboardmodel->count_yesterdayAddedLead();
                echo '<h4 class="title">Yesterday added Leads: <a href="'.base_url("lms/listall?added_date=yesterday").'">'.$num.'</a></h4>';
                $num = $this->dashboardmodel->count_weekAddedLead();
                echo '<h4 class="title">This Week added: <a href="'.base_url("lms/listall?added_date=week").'">'.$num.'</a></h4>';
                $num = $this->dashboardmodel->count_monthAddedLead();
                echo '<h4 class="title">This Month added: <a href="'.base_url("lms/listall?added_date=month").'">'.$num.'</a></h4>';
                ?>
              </div>
              <div class="summary-footer">
                <a class="text-muted text-uppercase">(view all)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-md-12 col-lg-6 col-xl-6">
      <section class="panel panel-featured-left panel-featured-quartenary">
        <div class="panel-body">
          <div class="widget-summary">
            <div class="widget-summary-col widget-summary-col-icon">
              <div class="summary-icon bg-quartenary">
                <i class="fa fa-user"></i>
              </div>
            </div>
            <div class="widget-summary-col">
              <div class="summary">

                <?php
                $lead_status = $this->dashboardmodel->listallLeadStatus();
                foreach ($lead_status->result() as $row) {
                  $num = $this->dashboardmodel->count_leadsStatus($row->status_id);
                  echo '<h4 class="title">'.$row->status_name.': <a href="'.base_url("lms/listall?status=".$row->status_id).'">'.$num.'</a></h4>';
                }
                echo "</br>";

                ?>
              </div>
              <div class="summary-footer">
                <a class="text-muted text-uppercase">(view all)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- today sales -->









  </div>
</div>
</div>




<!-- Form -->


<div class="row">
  <div class="col-xl-3 col-lg-6">
    <section class="panel panel-transparent">

      <div class="panel-body">
        <section class="panel panel-group">

          <div id="accordion">
            <div class="panel panel-accordion panel-accordion-first">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="accordion-toggle" style="width:200px;float:left;" data-toggle="collapse" data-parent="#accordion" href="#collapse1One">
                    <i class="fa fa-check"></i> Current Tasks
                  </a>
                  <?php if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkpermDashboard("TASK","ADD")) {?>
                  <a class="popup-with-form" href="#demo-form" style="width:30px;float:left;"><i class="glyphicon glyphicon-plus-sign"></i></a>
                  <?php } ?>
                </h4>
                <div style="clear:both;"></div>
              </div>

              <div id="collapse1One" class="accordion-body collapse in">
                <div class="panel-body">
                  <form action="<?php echo base_url("task/complete");?>" method="post">
                    <ul class="widget-todo-list">
                      <li>
                        <div class="checkbox-custom checkbox-default" style="width:80%">
                          <input type="checkbox"  id="checkall" class="">
                          <label  for="todoListItem"><span>Task</span></label>
                        </div>

                        <div class="todo-actions" style="width:20%">
                          Sale Reps
                        </div>
                      </li>
                      <?php 
                      $tasks = $this->dashboardmodel->get_currenttask(5);
                      foreach ($tasks as $task) {
                        ?>
                        <li>
                          <div class="checkbox-custom checkbox-default" style="width:80%">
                            <input type="checkbox" name="tasklist<?php echo $task->task_id;?>" <?php if($task->task_status==4) echo 'checked=""';?>  id="todoListItem<?php echo $task->task_id;?>" value="<?php echo $task->task_id; ?>" class="todo-check tasks">

                            <label class="todo-label" id="<?php echo $task->task_id;?>" for="todoListItem<?php echo $task->task_id;?>">
                              <a class="popup-with-form link_update" href="#task-form" id="<?php echo $task->task_id;?>" >
                                <span><?php echo $task->task_name;?></span>
                              </a>
                            </label>
                            <input type="hidden" name="taskid[]" value="<?php echo $task->task_id;?>">
                          </div>

                          <div class="todo-actions" style="width:20%">
                            <a class="" href="#">
                              <?php echo $task->first_name.' '.$task->last_name; ?>
                            </a>
                          </div>
                        </li>
                        <?php
                      }
                      ?>

                      <a href="<?php echo base_url("task/listall");?>" class="mb-xs mt-xs mr-xs btn " style="float:right;"> All Task</a>
                      <br>
                      <li>
                        <div class="checkbox-custom checkbox-default" style="width:60%">
                         <input type="submit" name="complete" value="Complete" class="mb-xs mt-xs mr-xs btn btn-success">
                       </div>

                       <?php if($this->session->userdata("clms_front_user_group") == 1){ ?>
                       <div class="todo-actions" style="width:20%">
                        <input type="submit" name="archive" value="Archive" class="mb-xs mt-xs mr-xs btn btn-warning">
                      </div>
                      <?php } ?>

                    </li>
                  </ul>
                </form>
              </div>
            </div>
          </div>

        </div>
      </section>

    </div>
  </section>
</div>

<div class="col-xl-3 col-lg-6">
  <section class="panel panel-transparent">

    <div class="panel-body">
      <section class="panel panel-group">

        <div id="accordion">
          <div class="panel panel-accordion panel-accordion-first">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2One">
                  <i class="fa fa-check"></i> Archive
                </a>
              </h4>
            </div>
            <div id="collapse2One" class="accordion-body collapse in">
              <div class="panel-body">
                <ul class="widget-todo-list">
                 <li>
                  <div class="checkbox-custom checkbox-default" style="width:80%">
                    <label  for="todoListItem"><span>Task</span></label>
                  </div>
                  <div class="todo-actions" style="width:20%">
                    Sale Reps
                  </div>
                </li>
                <?php 
                $archived = $this->dashboardmodel->get_Archivedtask(5);
                if(count($archived)>0){
                  foreach ($archived as $task) {
                    ?>
                    <li>
                      <div class="checkbox-custom checkbox-default" style="width:80%">
                        <input type="checkbox" name="tasklist<?php echo $task->task_id;?>" <?php if($task->task_status=="Completed") echo 'checked=""';?>  id="todoListItem<?php echo $task->task_id;?>" value="<?php echo $task->task_id; ?>" class="todo-check tasks">

                        <label class="todo-label" id="<?php echo $task->task_id;?>" for="todoListItem<?php echo $task->task_id;?>"><a class="simple-ajax-popup btn-default" class="todo-label" for="todoListItem<?php echo $task->task_id;?>" href="<?php echo base_url("task/task_detail/".$task->task_id);?>"><span><?php echo $task->task_name;?></span></a></label>
                        <input type="hidden" name="taskid[]" value="<?php echo $task->task_id;?>">
                      </div>
                      
                      <div class="todo-actions" style="width:20%">
                        <a class="" href="#">
                          <?php echo $task->first_name.' '.$task->last_name; ?>
                        </a>
                      </div>
                    </li>
                    <?php
                  }?>
                  <li>
                    <div class="todo-actions" style="width:20%">
                      <a href="<?php echo base_url("task/listall");?>"> All Task</a>
                    </div>
                  </li>
                  <?php
                }else{
                  ?>
                  <li>
                    No Data found...
                  </li>
                  <?php
                }
                ?>
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
<div class="col-md-6 col-lg-12 col-xl-6">
  <div class="row">
    <div class="col-md-12 col-lg-6 col-xl-6">
      <section class="panel panel-featured-left panel-featured-quartenary">
        <div class="panel-body">
          <div class="widget-summary">
            <div class="widget-summary-col widget-summary-col-icon">
              <div class="summary-icon bg-quartenary">
                <i class="fa fa-user"></i>
              </div>
            </div>
            <div class="widget-summary-col">
              <div class="summary">
               <?php
                //$todays = $this->dashboardmodel->count_todayAddedLead(strtotime(date("Y-m-d")));
               $num = $this->dashboardmodel->count_todaySale();
               echo '<h4 class="title">Todays Sale: <a href="'.base_url("project/listall?added_date=today").'">$'.round(floatval($num),2).'</a></h4>';
               $num = $this->dashboardmodel->count_yesterdaySale();
               echo '<h4 class="title">Yesterday Sale: <a href="'.base_url("project/listall?added_date=yesterday").'">$'.round(floatval($num),2).'</a></h4>';
               $num = $this->dashboardmodel->count_weekSale();
               echo '<h4 class="title">This Week Sale: <a href="'.base_url("project/listall?added_date=week").'">$'.round(floatval($num),2).'</a></h4>';
               $num = $this->dashboardmodel->count_monthSale();
               echo '<h4 class="title">This Month Sale: <a href="'.base_url("project/listall?added_date=month").'">$'.round(floatval($num),2).'</a></h4>';
               ?>
             </div>
             <div class="summary-footer">
              <a class="text-muted text-uppercase">(view all)</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-md-12 col-lg-6 col-xl-6">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-primary">
              <i class="fa fa-life-ring"></i>
            </div>
          </div>
          <div class="widget-summary-col">
            <div class="summary">
             <?php
             $project_status = $this->dashboardmodel->listallProjectStatus();
             foreach ($project_status->result() as $row) {
              $num = $this->dashboardmodel->count_Projects($row->status_id);
              echo '<h4 class="title">'.$row->status_name.': <a href="'.base_url("project/listall?project_status=".$row->status_id).'">'.intval($num).'</a></h4>';
            }

            $num = $this->dashboardmodel->count_weekProject();
            echo '<h4 class="title">This Week deadline Projects: <a href="'.base_url("project/listall?deadline=week").'">'.intval($num).'</a></h4>';
            $project_type = $this->dashboardmodel->listporjectType();
            foreach ($project_type->result() as $row) {
              $num = $this->dashboardmodel->count_ProjectType($row->type_id);
              echo '<h4 class="title">This Month '.$row->type_name.': <a href="'.base_url("project/listall?type=".$row->type_id."&added_date=month").'">'.intval($num).'</a></h4>';
            }
            ?>

          </div>
          <div class="summary-footer">
            <a class="text-muted text-uppercase">(view all)</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="col-md-12 col-lg-6 col-xl-6">
  <section class="panel panel-featured-left panel-featured-primary">
    <div class="panel-body">
      <div class="widget-summary">
        <div class="widget-summary-col widget-summary-col-icon">
          <div class="summary-icon bg-primary">
            <i class="fa fa-life-ring"></i>
          </div>
        </div>
        <div class="widget-summary-col">
          <div class="summary">
           <?php
           $project_type = $this->dashboardmodel->listporjectType();
           foreach ($project_type->result() as $row) {
             $num = $this->dashboardmodel->count_monthSale($row->type_id);
             echo '<h4 class="title">This month '.$row->type_name.' Sale: <a href="'.base_url("project/listall?added_date=month&type=".$row->type_id).'">$'.round(floatval($num),2).'</a></h4>';
           }

           $num = $this->dashboardmodel->count_monthSale();
           echo '<h4 class="title">This month total lead Sale: <a href="'.base_url("project/listall?added_date=month").'">$'.round(floatval($num),2).'</a></h4>';
           ?>

         </div>
         <div class="summary-footer">
          <a class="text-muted text-uppercase">(view all)</a>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<div class="col-md-12 col-lg-6 col-xl-6">
  <section class="panel panel-featured-left panel-featured-primary">
    <div class="panel-body">
      <div class="widget-summary">
        <div class="widget-summary-col widget-summary-col-icon">
          <div class="summary-icon bg-primary">
            <i class="fa fa-life-ring"></i>
          </div>
        </div>
        <div class="widget-summary-col">
          <div class="summary">
            <?php
            $project_type = $this->dashboardmodel->listporjectType();
            foreach ($project_type->result() as $row) {
             $num = $this->dashboardmodel->count_monthCommission($row->type_id);
             echo '<h4 class="title">This month '.$row->type_name.' commission: <a href="'.base_url("project/listall?added_date=month&type=".$row->type_id).'">$'.round(floatval($num),2).'</a></h4>';
           }
           $num = $this->dashboardmodel->count_monthCommission();
           echo '<h4 class="title">This month total commission: <a href="'.base_url("project/listall?added_date=month").'">$'.round(floatval($num),2).'</a></h4>';
           ?>


         </div>
         <div class="summary-footer">
          <a class="text-muted text-uppercase">(view all)</a>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
</div>
</div>
<?php 
if($this->session->userdata("clms_front_user_group") == 1){
  ?>

  <div class="row">

   <div class="col-xl-3 col-lg-6">
    <section class="panel panel-transparent">

      <div class="panel-body">
        <section class="panel panel-group">

          <div id="accordion">
            <div class="panel panel-accordion panel-accordion-first">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1One">
                    <i class="fa fa-check"></i> Pending Task
                  </a>
                </h4>
              </div>

              <div id="collapse1One" class="accordion-body collapse in">
                <div class="panel-body">
                  <form action="<?php echo base_url("task/complete");?>" method="post">
                    <ul class="widget-todo-list">
                      <li>
                        <div class="checkbox-custom checkbox-default" style="width:80%">

                          <label  for="todoListItem"><span>Task</span></label>
                        </div>

                        <div class="todo-actions" style="width:20%">
                          Sale Reps
                        </div>
                      </li>
                      <?php 
                      $tasks = $this->dashboardmodel->not_assigntask(5);
                      foreach ($tasks as $task) {
                        ?>
                        <li>
                          <div class="checkbox-custom checkbox-default" style="width:80%">
                            <input type="checkbox" name="tasklist<?php echo $task->task_id;?>" <?php if($task->task_status=="Completed") echo 'checked=""';?>  id="todoListItem<?php echo $task->task_id;?>" value="<?php echo $task->task_id; ?>" class="todo-check tasks">

                            <label class="todo-label" id="<?php echo $task->task_id;?>" for="todoListItem<?php echo $task->task_id;?>"><a class="simple-ajax-popup btn-default" class="todo-label" for="todoListItem<?php echo $task->task_id;?>" href="<?php echo base_url("task/task_detail/".$task->task_id);?>"><span><?php echo $task->task_name;?></span></a></label>
                            <input type="hidden" name="taskid[]" value="<?php echo $task->task_id;?>">
                          </div>

                          <div class="todo-actions" style="width:20%">
                            <a class="" href="#">
                              <?php echo $task->first_name.' '.$task->last_name; ?>
                            </a>
                          </div>
                        </li>
                        <?php
                      }
                      ?>

                    </ul>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </section>

      </div>
    </section>
  </div>

  <div class="col-lg-6 col-md-12">
    <section class="panel">
      <header class="panel-heading panel-heading-transparent">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Not Assigned Lead</h2>
      </header>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped mb-none">
            <thead>
              <tr>
                <th>#</th>
                <th>Project</th>
                <th>Company</th>
                <th>Phone</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $leads = $this->dashboardmodel->get_notAssignLeads();
              $i = 1;
              if(count($leads)>0){
                foreach ($leads as $lead) {

                  ?>
                  <tr>
                    <td><?php echo $i;?> </td>
                    <td><a class="simple-ajax-popup btn-default"   href="<?php echo base_url("lms/detail/".$lead->lead_id);?>"><?php echo $lead->lead_name;?></a></td>
                    <td><?php echo $lead->company_name;?></td>
                    <td><?php echo $lead->phone_number;?></td>
                  </tr>
                  <?php
                  $i++;
                }}else{
                  ?>
                  <tr>
                    <td colspan="4">No Data found.</td>
                  </tr>
                  <?php
                }
                ?>

              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php } ?>
  
  <!-- end: page -->
</section>
</div>

<aside id="sidebar-right" class="sidebar-right">
  <div class="nano">
    <div class="nano-content">
      <a href="#" class="mobile-close visible-xs">
        Collapse <i class="fa fa-chevron-right"></i>
      </a>

      <div class="sidebar-right-wrapper">

        <div class="sidebar-widget widget-calendar">
          <h6>Upcoming Tasks</h6>
          <div data-plugin-datepicker data-plugin-skin="dark" ></div>

          <ul>
            <li>
              <time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
              <span>Company Meeting</span>
            </li>
          </ul>
        </div>

        <div class="sidebar-widget widget-friends">
          <h6>Friends</h6>
          <ul>
            <li class="status-online">
              <figure class="profile-picture">
                <img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
              </figure>
              <div class="profile-info">
                <span class="name">Joseph Doe Junior</span>
                <span class="title">Hey, how are you?</span>
              </div>
            </li>
            <li class="status-online">
              <figure class="profile-picture">
                <img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
              </figure>
              <div class="profile-info">
                <span class="name">Joseph Doe Junior</span>
                <span class="title">Hey, how are you?</span>
              </div>
            </li>
            <li class="status-offline">
              <figure class="profile-picture">
                <img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
              </figure>
              <div class="profile-info">
                <span class="name">Joseph Doe Junior</span>
                <span class="title">Hey, how are you?</span>
              </div>
            </li>
            <li class="status-offline">
              <figure class="profile-picture">
                <img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
              </figure>
              <div class="profile-info">
                <span class="name">Joseph Doe Junior</span>
                <span class="title">Hey, how are you?</span>
              </div>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </div>
</aside>
</section>
<div class="modal fade" id="divloader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  style="width:100%;height:100%;background:#ccc;opacity: .55;">
  <div class="divloader" style="left: 50%; top: 50%; z-index:1000; width: 30px; height:30px; position: fixed; background:url('<?php echo base_url(); ?>themes/images/loader.gif') no-repeat center center;opacity:1;"></div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
   // $("#editgroup").modal('show');
   $('#checkall').click(function() {
    $(".tasks").filter(':checkbox').prop('checked', this.checked);
  });
 });
</script>



<form id="demo-form" method="post" class="white-popup-block mfp-hide form-horizontal" action="<?php echo base_url("task/add");?>">
  <div class="row">
    <div class="col-sm-12">
      <h3>Add New Task</h3>
    </div>
  </div>

  <div class="form-group mt-lg">
    <label class="col-sm-3 control-label">Task Title</label>
    <div class="col-sm-9">
      <input type="text" name="name"  class="form-control" placeholder="" required/>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label">Task Details</label>
    <div class="col-sm-9">
     <textarea name="details" id="trumbowyg"  class="form-control" rows="8" required></textarea>
   </div>
 </div>
 <?php if($this->session->userdata("clms_front_user_group") == 1 || $this->session->userdata("clms_front_user_group") == 7){ ?>
 <div class="form-group">
   <label class="col-sm-3 control-label">Assign to</label>
   <div class="col-sm-9">
    <select class="form-control" name="assign_to" required>
      <option value="">Select</option>
      <?php 
      foreach ($users as $user ) {
        ?>
        <option value="<?php echo $user->userid;?>"><?php echo $user->first_name." ".$user->last_name;?></option>
        <?php
      }
      ?>
    </select>
  </div>
</div>
<?php
}
?>
<div class="form-group">
  <label class="col-sm-3 control-label">Status</label>
  <div class="col-sm-9">
    <select class="form-control" name="status" required>
      <option value="">Select</option>
      <?php 
      foreach ($task_status as $row) {
       ?>
       <option value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
       <?php
     }
     ?>
   </select>
 </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Priority</label>
  <div class="col-sm-9">
    <select class="form-control" name="priority" required>
      <option value="">Select</option>
      <option value="Normal">Normal</option>
      <option value="High">High</option>
      <option value="Urgent">Urgent</option>
    </select>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Start Date</label>
  <div class="col-sm-9">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="start_date" class="form-control">
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">End Date</label>
  <div class="col-sm-9">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="end_date" class="form-control">
    </div>
  </div>
</div>

<div class="row mb-lg">
  <div class="col-sm-9 col-sm-offset-3">
    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    <button type="reset" class="btn btn-default">Reset</button>
  </div>
</div>

</form>

<form id="task-form" method="post" class="white-popup-block mfp-hide form-horizontal" action="<?php echo base_url("task/add");?>">
  <div class="row">
    <div class="col-sm-12">
      <h3>Add Task Update</h3>
    </div>
  </div>

  
  <div class="form-group">
    <label class="col-sm-3 control-label">Task Details</label>
    <div class="col-sm-9">
     <textarea name="detail123" id="detail123"  class="form-control" rows="8" required></textarea>
   </div>
 </div>

 <div class="row mb-lg">
  <div class="col-sm-9 col-sm-offset-3">
    <input type="hidden" name="update_task_id" id="update_task_id" value="0">
    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    <button type="reset" class="btn btn-default">Reset</button>
  </div>
</div>

</form>

<form id="lead-form" method="post" class="white-popup-block mfp-hide form-horizontal" action="<?php echo base_url("lms/add");?>" enctype='multipart/form-data'>
  <div class="row">
    <div class="col-sm-12">
      <h3>Add New Lead</h3>
    </div>
  </div>

  <div class="form-group mt-lg">
    <label class="col-md-3 control-label" for="inputDefault">Name</label>
    <div class="col-md-6">
      <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Company Name</label>
    <div class="col-md-6">
      <input type="text" name="company" value="<?php echo set_value("company");?>"  class="form-control" id="company" >
      <?php echo form_error("company");?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Email</label>
    <div class="col-md-6">
      <input type="email" name="email" value="<?php echo @$db->email;?>"  class="form-control" id="email" required>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Country</label>
    <div class="col-md-6">
      <select class="form-control mb-md" name="country">
        <option value="">Country</option>
        <?php
        foreach ($countries as $country) {
         ?>
         <option <?php if("Australia" == $country->country_name) echo 'selected="selected"';?> value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
         <?php
       }
       ?>
     </select>
   </div>
 </div>

 <div class="form-group">
  <label class="col-md-3 control-label">Phone</label>
  <div class="col-md-6 control-label">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-phone"></i>
      </span>
      <input id="phone" name="phone" value="<?php echo @$db->phone;?>" data-plugin-masked-input=""  class="form-control">
    </div>
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Chat Id</label>
  <div class="col-md-2">
    <select name="chat_name" id="chat_name" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 
      foreach($chats as $chat){
        ?>
        <option value="<?php echo $chat->chat_id;?>"><?php echo $chat->chat_name;?></option>
        <?php
      }
      ?>

    </select>
  </div>
  <div class="col-md-4">
    <input type="text" name="chat_id" value="<?php echo set_value("chat_id");?>"  class="form-control" id="chat_id" >
    <?php echo form_error("chat_id");?>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Query</label>
  <div class="col-md-6">
    <input type="text" name="query" class="form-control" id="query">
    <?php echo form_error("query");?>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Document</label>
  <div class="col-md-6" id="div_document">
    <input type="file" name="document1" class="form-control doccuments"> 
  </div>
  <a href="javascript:void(0);" id="add_more">Add</a>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Requirement</label>
  <div class="col-md-6">
   <textarea name="requirement" class="form-control"></textarea>

 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">When Start</label>
  <div class="col-md-6">
   <select name="when_start" class="form-control mb-md">
     <option value="">Select</option>
     <?php 
     foreach($starts as $start){
      ?>
      <option value="<?php echo $start->start_id;?>"><?php echo $start->start_name;?></option>
      <?php
    }
    ?>
  </select>
</div>
</div>
<header class="panel-heading" style="margin-bottom: 10px;">
  <h2 class="panel-title">Sales Person Report</h2>
</header>
<div class="form-group">
  <label class="col-md-3 control-label">Reminder Date</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="date" class="form-control" required>
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Reminder Time</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-clock-o"></i>
      </span>
      <input type="text" data-plugin-timepicker="" name="time" value="0:00" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }">
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Remark</label>
  <div class="col-md-6">
    <textarea name="remark" class="form-control"></textarea>

  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Next Action</label>
  <div class="col-md-6">
    <textarea name="action" class="form-control"></textarea>

  </div>
</div>
<header class="panel-heading" style="margin-bottom: 10px;">
  <h2 class="panel-title">Status Update</h2>
</header>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Today</label>
  <div class="col-md-6">
    <textarea name="status_update" class="form-control"></textarea>
  </div>
</div>
<header class="panel-heading" style="margin-bottom: 10px;">
  <h2 class="panel-title">Select Options</h2>
</header>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Category</label>
  <div class="col-md-6">
    <select name="category" id="category" class="form-control mb-md" required>
      <option value="">Select</option>
      <?php 
      foreach ($category as $cat) {
        ?>
        <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
        <?php 
      }
      ?>
    </select>
  </div>
</div>
<div class="form-group" id="div_sub_category" style="display:none;">
  <label class="col-md-3 control-label" for="inputDefault">Sub Category</label>
  <div class="col-md-6">
    <select name="sub_category" id="sub_category" class="form-control mb-md" >
      <option value="">Select</option>

    </select>
  </div>
</div>
<div class="form-group" id="div_sub_category2" style="display:none;">
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 2nd</label>
  <div class="col-md-6">
    <select name="sub_category2" id="sub_category2" class="form-control mb-md" >
      <option value="">Select</option>

    </select>
  </div>
</div>

<div class="form-group" id="div_sub_category3" style="display:none;">
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 3rd</label>
  <div class="col-md-6">
    <select name="sub_category3" id="sub_category3" class="form-control mb-md" >
      <option value="">Select</option>

    </select>
  </div>
</div> 

<div class="form-group" id="div_sub_category4" style="display:none;">
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 4th</label>
  <div class="col-md-6">
    <select name="sub_category4" id="sub_category4" class="form-control mb-md" >
      <option value="">Select</option>

    </select>
  </div>
</div> 

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Access</label>
  <div class="col-md-6">
   <select name="access" class="form-control mb-md">
    <?php 
    foreach ($access as $acc) {
      ?>
      <option value="<?php echo $acc->access_id;?>"><?php echo $acc->access_name;?></option>
      <?php
    }
    ?>

  </select>
</div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Language</label>
  <div class="col-md-6">
   <select name="language" class="form-control mb-md">
    <option value="">Select</option>
    <?php 
    foreach($languages as $lang){
      ?>
      <option <?php if($lang->language_id == 36) echo 'selected="selected"';?> value="<?php echo $lang->language_id;?>"><?php echo $lang->language_name;?></option>
      <?php
    }
    ?>
  </select>
</div>
</div>
<div class="row mb-lg">
  <div class="col-sm-9 col-sm-offset-3">
    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    <button type="reset" class="btn btn-default">Reset</button>
  </div>
</div>

</form>

<script type="text/javascript">
  $(document).ready(function(){
    $("#lead-form").validate();
    $("#demo-form").validate();

    $("#add_more").click(function(){
      var len = $(".doccuments").length;
      len = len + 1;
      $("#div_document").append('<input type="file" name="document'+len+'" class="form-control doccuments" style="margin-top:10px;">');
    });

    $("#category").change(function(){
     $("#div_sub_category").hide();
     $("#div_sub_category2").hide();
     $("#div_sub_category3").hide();
     $("#div_sub_category4").hide();
     jQuery("#sub_category option[value='']").attr('selected', 'selected');
     jQuery("#sub_category2 option[value='']").attr('selected', 'selected');
     jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
     jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
     var catid = $(this).val();
     $.ajax({
      url: '<?php echo base_url() ?>lms/get_subcategory',
      type: "POST",
      data: "catid=" + catid,
      success: function(data) { 
        if(data != ""){
          $("#sub_category").html(data);
          $("#div_sub_category").show();
        }
      }        
    });
   });

    $("#sub_category").on("change",function(){
      $("#div_sub_category2").hide();
      $("#div_sub_category3").hide();
      $("#div_sub_category4").hide();
      jQuery("#sub_category2 option[value='']").attr('selected', 'selected');
      jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
      jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
      var catid = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>lms/get_subcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_category2").html(data);
            $("#div_sub_category2").show();
          }
        }        
      });
    });

    $("#sub_category2").on("change",function(){
      $("#div_sub_category3").hide();
      $("#div_sub_category4").hide();

      jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
      jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
      var catid = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>lms/get_subcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_category3").html(data);
            $("#div_sub_category3").show();
          }
        }        
      });
    });

    $("#sub_category3").on("change",function(){
      $("#div_sub_category4").hide();
      jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
      var catid = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>lms/get_subcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_category4").html(data);
            $("#div_sub_category4").show();
          }
        }        
      });
    });

    $(".link_delete").click(function(){
      if(!confirm("Are you sure to delete this Record?"))
        return false;
    });
    $(".link_update").click(function(){
      var taskid = $(this).attr("id");
      $("#update_task_id").val(taskid);
    });
  });
</script>
