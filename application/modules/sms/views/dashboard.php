 <?php if($this->session->flashdata("success_message")){?>
 <div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
</div>
<?php
}
?>

<?php if($this->session->flashdata("error")){?>
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Opps!</strong> <?php echo $this->session->flashdata("error"); ?> 
</div>
<?php
}
?>


<div class="row">
  <div class="col-md-12 col-lg-4 col-xl-4">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-primary">
              <i class="glyphicon glyphicon-lock"></i>
            </div>
          </div>

          <div class="widget-summary-col">
            <div class="summary">
              <h3 class="title"><strong> SMS Credit</strong></h3>

              <div class="info">

                <?php echo @$result->sms_credit;?>
              </div>

              <div class="info">
                <strong >&nbsp; </strong>
                <span class="text-primary">&nbsp;</span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-md-12 col-lg-4 col-xl-4">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-primary">
              <i class="glyphicon glyphicon-lock"></i>
            </div>
          </div>

          <div class="widget-summary-col">
            <div class="summary">
              <h3 class="title"><strong> Used SMS Credit</strong></h3>

              <div class="info">

               <?php echo @$result->used_sms;?>
             </div>

             <div class="info">
              <strong >&nbsp; </strong>
              <span class="text-primary">&nbsp;</span>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>
<div class="col-md-12 col-lg-4 col-xl-4">
  <section class="panel panel-featured-left panel-featured-primary">
    <div class="panel-body">
      <div class="widget-summary">
        <div class="widget-summary-col widget-summary-col-icon">
          <div class="summary-icon bg-primary">
            <i class="glyphicon glyphicon-lock"></i>
          </div>
        </div>

        <div class="widget-summary-col">
          <div class="summary">
            <h3 class="title"><strong> Balance SMS Credit</strong></h3>

            <div class="info">

              <?php echo @$result->balance_sms;?>
            </div>

            <div class="info">
              <strong >&nbsp; </strong>
              <span class="text-primary">&nbsp;</span>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>
</div>

<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title"> Sms History : </h2>
      </header>
      <div class="panel-body">

       <table class="table table-bordered table-striped mb-none" id="datatable-default">
        <thead>
          <tr>
            <th>Sms Content</th>
            <th>Numbers</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          foreach ($sent->result() as $sent_sms) {

           ?>
           <tr class="gradeX">

             <td><?php echo $sent_sms->sms_content;?></td>
             <td><?php echo $sent_sms->mobile;?></td>
             <td><?php echo date("d-m-Y",strtotime($sent_sms->sent_date));?></td>
           </tr>
           <?php
         } ?>


       </tbody>
     </table>

   </div>
 </section>
</div>
</div>
<!-- end: page -->

<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
       
        <h2 class="panel-title"> Send Sms : <a href="<?php echo base_url("sms_subscribers/add")?>" class="btn btn-primary" style="float:right;">Add sms contact</a></h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>

            <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Sms Subscribers</label>
            <div class="col-md-6">
              <select name="subscribers[]"  data-plugin-selectTwo multiple="multiple" data-plugin-multiselect data-plugin-options='{ "includeSelectAllOption": true }' id="subscribers" class="form-control">
                <?php

                foreach ($sms_subscribers->result() as $row) {
                 ?>
                 <option value="<?php echo $row->mobile_number;?>" 
                  <?php //if(set_value("subscribers") == $row->mobile_number) echo 'selected="selected"'; ?>
                  ><?php echo $row->name;?> (<?php echo $row->mobile_number;?>)</option>
                  <?php
                }
                ?>
              </select>

            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Customer</label>
            <div class="col-md-6">
              <select name="customer[]"  data-plugin-selectTwo multiple="multiple" data-plugin-multiselect data-plugin-options='{ "includeSelectAllOption": true }' id="ms_example5" class="form-control">
                <?php
                foreach ($customers->result() as $row) {
                 ?>
                 <option value="<?php echo $row->mobile;?>" 
                  <?php //if(set_value("customer") == $row->mobile_number) echo 'selected="selected"'; ?>
                  ><?php echo $row->first_name.' '.$row->last_name;?> (<?php echo $row->mobile;?>)</option>
                  <?php
                }
                ?>
              </select>

            </div>
          </div>

           <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Contractor</label>
            <div class="col-md-6">
              <select name="contractor[]"  data-plugin-selectTwo multiple="multiple" data-plugin-multiselect data-plugin-options='{ "includeSelectAllOption": true }' id="subscribers" class="form-control">
                <?php

                foreach ($sms_subscribers_contractor->result() as $row) {
                 ?>
                 <option value="<?php echo $row->mobile_number;?>" 
                  <?php //if(set_value("subscribers") == $row->mobile_number) echo 'selected="selected"'; ?>
                  ><?php echo $row->name;?> (<?php echo $row->mobile_number;?>)</option>
                  <?php
                }
                ?>
              </select>

            </div>
          </div>


          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Other Numbers</label>
            <div class="col-md-6">
              <textarea name="other_numbers" class="form-control"><?php echo set_value("other_numbers")?></textarea>
              <label>Add the valid Mobile Numbers seperated by comma.</label>
            </div>
            <div class="col-md-3">
              <label class="error"><?php echo form_error('other_numbers');?></label>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Sms content</label>
            <div class="col-md-6">
             <textarea name="content" id="sms_content" class="form-control required" rows="5"><?php echo set_value("content")?></textarea>
             <label style="float:left;"> Note: 1 SMS=160 Characters</label>
             <label style="float:right;"> <span id="span_number">0</span> / 918 characters</label>
             <div class="col-md-3"> <label class="error"><?php echo form_error('content');?></label></div>
           </div>
         </div>

         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">

            <input type="submit" name="submit" value="Send Sms" class="mb-xs mt-xs mr-xs btn btn-success">

          </div>
        </div>
      </form>
    </div>
  </section>
</div>
</div>
<!-- end: page -->
</section>
</div>
</section>
<script type="text/javascript">
  $(document).ready(function(){
    $('#sms_content').keypress(function(e) {
      var tval = $(this).val();
      tlength = tval.length;
      set = 918;
      remain = parseInt(set - tlength);
      $('#span_number').text(tlength);
      if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
        $(this).val((tval).substring(0, tlength - 1));
        return false;
      }
    })
  });
</script>