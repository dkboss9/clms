
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


<div class="row">
  <div class="col-xs-12">
    <section class="panel form-wizard" id="w4">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
        </div>

        <h2 class="panel-title">visit : [Add]</h2>
      </header>
      <div class="panel-body">
        <div class="wizard-progress wizard-progress-lg">
          <div class="steps-progress">
            <div class="progress-indicator"></div>
          </div>
          <ul class="wizard-steps">
            <li class="active">
              <a href="#w4-account" data-toggle="tab" aria-expanded="true"><span>1</span>Patient Info</a>
            </li>
            <li class="">
              <a href="#w4-profile" data-toggle="tab" aria-expanded="false"><span>2</span>Profile Info</a>
            </li>

          </ul>
        </div>

        <form id="form" method="post" action="<?php echo base_url("visit/add");?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
          <div class="tab-content">
            <div id="w4-account" class="tab-pane active">
             <div class="form-group">
              <label class="col-md-3 control-label" for="title">Title</label>
              <div class="col-md-6">
                <select name="title" class="form-control" required>
                  <option value="">Select</option>
                  <option value="Mr">Mr</option>
                  <option value="Ms">Ms</option>
                  <option value="Mrs">Mrs</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Name</label>
              <div class="col-md-6">
                <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
                <?php echo form_error("name");?>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="dob">DOB</label>
              <div class="col-md-6">
                <input type="text" name="dob" value=""  data-plugin-datepicker=""  class="form-control" id="dob" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="title">Marital Status</label>
              <div class="col-md-6">
                <select name="marital_status" class="form-control" required>
                  <option value="">Select</option>
                  <option value="Married">Maried</option>
                  <option value="Unmarried">Unmarried</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="sex">Sex</label>
              <div class="col-md-6">
                <select name="sex" class="form-control" required>
                  <option value=""></option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="address">Address</label>
              <div class="col-md-6">
                <input type="text" name="address" value=""  class="form-control" id="address" required>

              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="address">P/code</label>
              <div class="col-md-6">
                <input type="text" name="postcode" value=""  class="form-control" id="postcode" required>

              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="contact_no">Contact No.</label>
              <div class="col-md-6">
                <input type="text" name="contact_no" value=""  class="form-control" id="contact_no" required>

              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="email">Email Address</label>
              <div class="col-md-6">
                <input type="email" name="email" value=""  class="form-control" id="email" required>

              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="medicare_number">Medicare Number</label>
              <div class="col-md-6">
                <input type="text" name="medicare_number" value=""  class="form-control" id="medicare_number" required>

              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="allery">Do you suffer any allergies?</label>
              <div class="col-md-6">
                <select name="allery" id="allergy" class="form-control" required>
                  <option value=""></option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
            </div>

            <div class="form-group" style="display:none;" id="div_allergy">
              <label class="col-md-3 control-label" for="allery"></label>
              <div class="col-md-6">
               <textarea name="txt_allergy" id="txt_allergy" class="form-control"></textarea>
             </div>
           </div>
           <div class="form-group">
            <label class="col-md-3 control-label" for="pregnant">Are you pregnant?</label>
            <div class="col-md-6">
              <select name="pregnant" class="form-control" required>
                <option value=""></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="medication">Do you take any Medication?</label>
            <div class="col-md-6">
              <select name="medication" id="medication" class="form-control" required>
                <option value=""></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="form-group" style="display:none;" id="div_medication">
            <label class="col-md-3 control-label" for="allery"></label>
            <div class="col-md-6">
             <textarea name="txt_medication" id="txt_medication" class="form-control"></textarea>
           </div>
         </div>

         <div class="form-group">
          <label class="col-md-3 control-label" for="doctor">Family Doctor Name & Contact</label>
          <div class="col-md-6">
            <input type="text" name="doctor" value=""  class="form-control" id="doctor" >

          </div>
        </div>
        <input type="hidden" name="tab" value="<?php echo $this->input->get("tab")? '1':'0';?>">
        <input type="hidden" name="form_visit" value="1">
      </div>
      <div id="w4-profile" class="tab-pane">

        <h6>A-History</h6>
        <div class="form-group">
          <label class="col-md-3 control-label">Present History</label>
          <div class="col-md-6">
           <textarea name="present_history" class="form-control"></textarea>
         </div>
       </div>

       <div class="form-group">
         <label class="col-md-3 control-label">Past History</label>
         <div class="col-md-6">
           <textarea name="past_history" class="form-control"></textarea>
         </div>
       </div>

       <h6>B-physical Examination</h6>
       <div class="form-group">
         <label class="col-md-3 control-label">Area of concern</label>
         <div class="col-md-6">
           <textarea name="concern" class="form-control"></textarea>
         </div>
       </div>
       <div class="form-group">
         <label class="col-md-3 control-label">General</label>
         <div class="col-md-6">
           <textarea name="general" class="form-control"></textarea>
         </div>
       </div>

       <div class="form-group">
         <label class="col-md-3 control-label">Appearance and Skin</label>
         <div class="col-md-6">
           <textarea name="appearance" class="form-control"></textarea>
         </div>
       </div>
       <div class="form-group">
         <label class="col-md-3 control-label">Head and neck</label>
         <div class="col-md-6">
           <textarea name="headneck" class="form-control"></textarea>
         </div>
       </div>
       <div class="form-group">
         <label class="col-md-3 control-label">Chest</label>
         <div class="col-md-6">
           <textarea name="chest" class="form-control"></textarea>
         </div>
       </div>

       <div class="form-group">
         <label class="col-md-3 control-label">Abdomen</label>
         <div class="col-md-6">
           <textarea name="abdomen" class="form-control"></textarea>
         </div>
       </div>

       <div class="form-group">
         <label class="col-md-3 control-label">Limbs</label>
         <div class="col-md-6">
           <textarea name="limbs" class="form-control"></textarea>
         </div>
       </div>
       <h6>C-Management Plan</h6>

       <div class="form-group">
        <label class="col-md-3 control-label">&nbsp;</label>
        <div class="col-md-6">
         <textarea name="management_plan" class="form-control"></textarea>
       </div>
     </div>
   </div>
 </form>
</div>
<div class="panel-footer">
  <ul class="pager">
    <li class="previous disabled">
      <a><i class="fa fa-angle-left"></i> Previous</a>
    </li>
    <li class="finish hidden pull-right">
      <a class="link_finish">Finish</a>
    </li>
    <li class="next">
      <a>Next <i class="fa fa-angle-right"></i></a>
    </li>
  </ul>
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
    $(".link_finish").click(function(){
     $("#form").submit();
   });
    $("#allergy").change(function(){
      if($(this).val() == "Yes"){
        $("#div_allergy").show();
      }else{
        $("#div_allergy").hide();
      }
    });
    $("#medication").change(function(){
      if($(this).val() == "Yes"){
        $("#div_medication").show();
      }else{
        $("#div_medication").hide();
      }
    });
  });
</script>