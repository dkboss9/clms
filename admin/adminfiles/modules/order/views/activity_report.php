

<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url("");?>assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">


  $(document).ready(function(){
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
                <div class="row">
               
            <div class="col-sm-12">
              <div class="mb-md">
              <form name="form_search" id="form_search" method="get" action="<?php echo current_url();?>">
                               
                               <table id="tg-adstype" class="table ">

                                 <tbody>


                                   <tr data-category="active">

                                     <td data-title="Photo">
                                       <input type="checkbox" name="custom" value="1" id="chk_custom" <?php if($custom == 1) echo 'checked="checked"'; ?>> Custom
                                     </td>

                                     <td data-title="Photo" class="span_date" <?php if($custom == 1) echo 'style="display:none;"'; ?>>
                                       <select name="date" class="form-control">
                                         <!-- <option value="">Select</option> -->
                                         <option value="today" <?php if($date == 'today') echo 'selected="selected"';?>>Today</option>
                                         <option value="week" <?php if($date == 'week') echo 'selected="selected"';?>>This Week</option>
                                         <option value="month" <?php if($date == 'month') echo 'selected="selected"';?>>This Month</option>
                                       </select>
                                     </td>
                                     <td data-title="Ad Status" class="span_custom" <?php if($custom != 1) echo 'style="display:none;"'; ?>>
                                       <input type="text" name="from_date" id="from_date1" class="form-control " value="<?php echo $from_date;?>" placeholder="From Date" readonly="">
                                     </td>
                                     <td data-title="Ad Status" class="span_custom" <?php if($custom != 1) echo 'style="display:none;"'; ?>>
                                       <input type="text" name="to_date" id="to_date1" class="form-control " value="<?php echo $to_date;?>" placeholder="To Date" readonly="">
                                     </td>
                                     <td data-title="Ad Status">
                                       <select name="order_id" id="order_id" class="form-control" data-plugin-selectTwo>
                                        <option value="">Project</option>
                                        <?php 
                                        foreach($installer->result() as $project){
                                          ?>
                                          <option value="<?php echo $project->order_id;?>" <?php echo $project->order_id == $orderid ? 'selected' :'';?>><?php echo $project->order_number;?></option>
                                          <?php
                                        }
                                        ?>
                                       </select>
                                     </td>
                                  
                                     <td>
                                     <select name="contractor" id="contractor" class="form-control" data-plugin-selectTwo>
                                        <option value="">Contractor</option>
                                        <?php 
                                        foreach ($installers as $row) {
                                        ?>
                                        <option value="<?php echo $row->user_id?>" rel="<?php echo $row->hourly_rate?>"  <?php echo $row->user_id == $contractor ? 'selected' :'';?>><?php echo $row->first_name. ' ' .$row->last_name;?></option>
                                        <?php 
                                      }
                                      ?>
                                    </select>
                                     </td>
                                     <td data-title="Ad Status"> <button type="submit" class="btn btn-primary">Search</button> </td>
                                     <td data-title="Ad Status"> <a href="<?php echo base_url("order/csv_activities?".http_build_query($this->input->get()?$this->input->get():[]));?>" class="btn btn-primary">CSV</a> </td>
                                   </tr>
                                 </tbody>
                               </table>
                               
                             </form>

              </div>
            </div>
          </div>

          <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
              <tr>
                <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
                <th>Date</th>
                <th>Order Number</th>
                <th>Nature of Project</th>
                <th>Customer</th>
                <th>Description</th>
                <th>Date & Time</th>
                <th>Deadline</th>
               
                <th>Start Time</th>
                <th>End Time</th>
                <th>Contractor</th>
                <?php 
                      if($this->session->userdata("usergroup") == 11){
                        ?>
                <th></th>
                      <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php 
              foreach ($activities->result() as $row) {
                $customer = $this->quotemodel->getCustomer($row->customer_id);
               ?>
               <tr class="gradeX">
                <td><input type="checkbox" class="checkone" value="<?php echo $row->id; ?>" /></td>
                <td><?php echo date("d-m-Y", strtotime($row->activity_date));?></td>
                <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("order/notes/".$row->order_id);?>"><?php echo $row->order_number;?></a></td>
                <td><?php echo $row->product;?></td>
                <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$customer->first_name.' '.$customer->last_name;?></a></td>
                <td><?php echo $row->description;?></td>
                <td><?php echo date("D",strtotime($row->installed_date));?>,<?php echo date("d/m/Y",strtotime($row->installed_date));?> at <?php echo $row->installed_time;?></td>
                <td><?php echo date("D",strtotime($row->installed_date));?>,<?php echo date("d/m/Y",strtotime($row->deadline_date));?> at <?php echo $row->deadline_time;?></td>
                
                <td><?php echo $row->start_time;?></td>
                <td><?php echo $row->end_time;?></td>
                <td>
                    <a class="simple-ajax-popup btn-default" href="<?php echo base_url("installer/details/".$row->threatre_id);?>"><?php echo $row->first_name.' '.$row->last_name;?>(<?php echo $row->position_type;?>)</a>
                </td>
                <?php 
                      if($this->session->userdata("usergroup") == 11){
                       ?>
                <th>
                  <?php  if(($row->activity_date == date("Y-m-d") || $row->activity_date == date('Y-m-d',strtotime("-1 days"))) ){
                        ?>
                   <a href="<?php echo base_url("order/edit_activity/$row->id")?>" class=""><span class="glyphicon glyphicon-edit" data-original-title="" title=""></span></a>
                  <?php } ?>  
              </th>
                      <?php } ?>
              </tr>
              <?php
            } ?>


          </tbody>
        </table>
      </div>
      <div id="customer" class="tab-pane <?php if($this->input->get("tab") && $this->input->get("tab") == "patient") echo 'active';?>">


      </div>
      <div id="quote" class="tab-pane <?php if($this->input->get("tab") && $this->input->get("tab") == "patient") echo 'active';?>">


      </div>
      <div id="orders" class="tab-pane <?php if($this->input->get("tab") && $this->input->get("tab") == "order") echo 'active';?>">


      </div>
    </div>
  </div>
</div>

</div>

</section>
</div>
</section>
<script type="text/javascript">
          $(document).ready(function(){
            $("#chk_custom").click(function(){
              if($(this).prop("checked")){
               $(".span_custom").show();
               $(".span_date").hide();
             }else{
               $(".span_custom").hide();
               $(".span_date").show();
             }
           });
            $("#from_date1").datepicker({
              format: 'dd/mm/yyyy'
            });

            $("#to_date1").datepicker({
              format: 'dd/mm/yyyy'
            });

          
          });
        </script>