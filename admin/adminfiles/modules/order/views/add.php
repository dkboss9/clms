

<?php 
if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
  ?>
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>We must tell you! </strong> Please select company to add this data.
  </div>
  <?php
}
?>
<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">order : [New]</h2>
      </header>
      <div class="panel-body">
      <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("order/add_order");?>" method="get" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Is Existing Quote ?</label>
            <div class="col-md-6">
              <input type="radio" name="is_existing" id="radio_yes" value="1" checked=""> Yes
              <input type="radio" name="is_existing" id="radio_no" value="0"> No
              <!-- <input type="radio" name="is_existing" id="radio_inhouse" value="2"> Inhouse -->
            </div>
          </div>

          <div class="form-group" id="div_old">
            <label class="col-md-3 control-label" for="sex">Quote Number</label>
            <div class="col-md-6">
              <input type="text" name="quote_number" id="quote_number" class="form-control required">
            </div>
            <?php //echo form_error("sex");?>
          </div>




          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="hidden" name="tab" value="<?php echo $this->input->get("tab")? '1':'0';?>">
              <input type="hidden" name="customer" value="<?php echo $this->input->get("customer")??0;?>">
           
              <input type="submit" name="submit" value="Submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <?php if($this->input->get("project")) { ?>
              <a href="<?php echo base_url("project/invoice/".$this->input->get("customer"));?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
              <?php }else{ ?>
                <a href="<?php echo base_url("order");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
             <?php } ?>
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
    $("#radio_yes").click(function(){
      $("#div_old").show();
      $("#div_new").hide();
      $("#quote_number").addClass("required")
    });

    $("#radio_no").click(function(){
      $("#div_old").hide();
      $("#div_new").show();
      $("#quote_number").removeClass("required")
    });

    $("#radio_inhouse").click(function(){
      $("#div_old").hide();
      $("#div_new").show();
      $("#quote_number").removeClass("required")
    });
  });
</script>

