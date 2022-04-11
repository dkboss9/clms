
<style type="text/css">
table {
  border-collapse: collapse;
}

td {
  padding-top: .5em;
  padding-bottom: .5em;
}
</style>


<div class="row">
  <div class="col-xs-12">
    <section class="panel form-wizard" id="w4">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle=""></a>
          <a href="#" class="" data-panel-dismiss=""></a>
        </div>

        <h2 class="panel-title">Client : [Add]</h2>
      </header>
      <div class="panel-body">
        <div class="wizard-progress wizard-progress-lg">
          <div class="steps-progress">
            <div class="progress-indicator"></div>
          </div>
          <ul class="wizard-steps">
            <li class="active">
              <a href="#w4-account" data-toggle="tab" aria-expanded="true"><span>1</span>Personal Info</a>
            </li>
            <li class="">
              <a href="#w4-profile" data-toggle="tab" aria-expanded="false"><span>2</span>Documents</a>
            </li>
            <li>
              <a href="#w4-billing" data-toggle="tab"><span>3</span>Qualifications</a>
            </li>
            
          </ul>
        </div>

        <form id="form_student" method="post" action="<?php echo base_url("student/add");?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
          <div class="tab-content">
            <div id="w4-account" class="tab-pane active">
             <div class="form-group">
              <label class="col-md-2 control-label" for="fname">First Name</label>
              <div class="col-md-3">
                <input type="text" name="fname" id="fname" value="<?php echo set_value("fname",@$lead->lead_name);?>" class="form-control " required  />
                <input type="hidden" name="role" id="role" value="3">
              </div>
              <label class="col-md-3 control-label" for="lname">Last Name</label>
              <div class="col-md-3">
                <input type="text" name="lname" id="lname" value="<?php echo set_value("lname",@$lead->lead_lname);?>" class="form-control"  required/>
              </div>
            </div>

        

          <div class="form-group">
            <label class="col-md-2 control-label">Email</label>
            <div class="col-md-3">
             <input type="email" name="email" id="email" value="<?php echo set_value("email",@$lead->email);?>" class="form-control"  required/>
             <?php if(form_error("email")){?>
             <label id="error_email" class="error"><?php echo form_error("email");?></label>
             <?php }?>
           </div>
           <label class="col-md-3 control-label" for="mobile">Mobile</label>
           <div class="col-md-3">
            <input type="text" name="mobile" id="mobile" value="<?php echo set_value("mobile");?>" class="form-control number"  required/>
          </div>
         </div>

      <div class="form-group">
      
       <label class="col-md-2 control-label" for="dob">DOB</label>
       <div class="col-md-3">
        <input type="text" name="dob" id="dob" data-plugin-datepicker="" value="<?php echo set_value("dob");?>" class="form-control"  />
      </div>

      <label class="col-md-3 control-label"> Photo </label>
  <div class="col-md-3">
    <input type="file" name="profile_pic" id="profile_pic" class="form-control">
    <input type="hidden" name="txt_profile_pic" id="txt_profile_pic" value="">
  </div>
  <div class="col-md-1" id="post_img_profile">

  </div>
     </div>

    <div class="form-group">
     <label class="col-md-2 control-label" for="passport_no">Passport No</label>
     <div class="col-md-3">
      <input type="text" name="passport_no" id="passport_no" value="<?php echo set_value("passport_no");?>" class="form-control"  />
    </div>
    <label class="col-md-3 control-label" for="lname">Phone</label>
    <div class="col-md-3">
      <input type="text" name="phone" id="phone" value="<?php echo set_value("phone",@$lead->phone_number);?>" class="form-control  number"  />
    </div>
  </div>




<div class="form-group">
 <label class="col-md-2 control-label" for="referral">Referral</label>
 <div class="col-md-3">
   <select name="referral" id="user" class="form-control  " data-plugin-selectTwo >
    <option value="">Select</option>
    <?php 
    foreach($users as $user){
      ?>
      <option value="<?php echo $user->id;?>" <?php if($user->id == set_value("referral",@$lead->user_id)) echo 'selected="selected"'; ?>><?php echo $user->first_name.' '.$user->last_name;?></option>
      <?php
    }
    ?>
  </select>
  <?php /* <input type="text" name="referral" id="referral" value="<?php echo set_value("referral");?>" class="form-control"  required/> */ ?>
</div>
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_user"><i class="glyphicon glyphicon-plus"></i></a>
</div>
<label class="col-md-2 control-label" for="address">Address</label>
 <div class="col-md-3">
  <input type="text" name="address" id="address" value="<?php echo set_value("address");?>" class="form-control"  />
</div>
</div>


<div class="form-group">
 <label class="col-md-2 control-label" for="sex">Sex</label>
 <div class="col-md-3">
   <select name="sex" id="sex" class="form-control " data-plugin-selectTwo>
     <option value="">Select</option>
     <option value="Male" <?php if(set_value("sex") == "Male") echo 'selected="selected"';?>>Male</option>
     <option value="Female" <?php if(set_value("sex") == "Female") echo 'selected="selected"';?>>Female</option>
   </select>
 </div>
 <label class="col-md-3 control-label" for="is_married">Marital Status</label>
 <div class="col-md-3">
  <select name="is_married" id="is_married" class="form-control " data-plugin-selectTwo>
   <option value="">Select</option>
   <option value="Single" <?php if(set_value("is_married") == "Single") echo 'selected="selected"';?>>Single</option>
   <option value="Married" <?php if(set_value("is_married") == "Married") echo 'selected="selected"';?>>Married</option>
 </select>
</div>
</div>


<div class="form-group">
  <label class="col-md-2 control-label">How do you know about us?</label>
  <div class="col-md-3">

    <select name="about_us" id="about_us" class="form-control " data-plugin-selectTwo>
      <option value="">Select</option>
      <?php 
      foreach($about_us as $row){
        ?>
        <option <?php if($row->threatre_id == set_value("about_us",@$lead->about_us)) echo 'selected="selected"';?> value="<?php echo $row->threatre_id;?>"><?php echo $row->name;?></option>
        <?php
      }
      ?>

    </select>
    
  </div>
  <div class="col-md-1">
    <a href="javascript:void(0);" id="link_about"><i class="glyphicon glyphicon-plus"></i></a>
  </div>
  <label class="col-md-2 control-label"></label>
  <div class="col-md-3">
    <input type="checkbox" name="send_email" id="send_email" checked="" value="1"> Send Email / Sms
  </div>
</div>



</div>
<div id="w4-profile" class="tab-pane">
<div class="table-responsive">
<table class="table table-bordered table-striped mb-none" id="">
    <thead>
        <tr>
            <th>Document Type</th>
            <th>Document </th>
            <th>Description</th>
            <th> </th>

        </tr>
    </thead>
    <tbody id="div_document">
      
        <tr>
            <td>
            <select name="doc_type[]" class="form-control mb-md" data-plugin-selectTwo>
        <option value="">Select</option>
        <?php
        foreach ($doc_type as $row) {
         ?>
         <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
         <?php
       }
       ?>
     </select>
            </td>
            <td>    <input type="file" name="document1" class="form-control mb-md" /></td>
            <td> <input type="text" name="description[]" class="form-control student_doc_desc mb-md"></td>
            <td>
                <a href="javascript:void(0);" class="link_remove"><i class="fa fa-trash-o"
                        aria-hidden="true"></i></a>
            </td>
        </tr>
      
    </tbody>
</table>

      </div>

<div class="form-group">
                <div class="col-md-12 " style="text-align: right;">
                    <br>
                    
                    <a href="javascript:void();" href="javascript:void(0);" id="link_add_doc" class="btn btn-primary">Add more</a>
            </div>
            </div>
</div>
<div id="w4-billing" class="tab-pane">
  <div class="form-group">
    <label class="col-sm-3 control-label" for="w4-cc">Have you completed an IELTS test in the last 2 years? </label>
    <div class="col-sm-6">
      <input type="radio" name="have_ielts" id="ielts_yes" value="1" checked=""> Yes
      <input type="radio" name="have_ielts" id="ielts_no" value="0"> No
    </div> 
  </div>
  <div id="div_ielts">
    <div class="form-group">
      <label class="col-sm-3 control-label" for="cc-via-online">Listening</label>
      <div class="col-sm-3">
        <input type="number" class="form-control required" name="listening" id="listening" value="" >
      </div>
      <label class="col-sm-2 control-label" for="cc-via-online">Writing</label>
      <div class="col-sm-3">
        <input type="number" class="form-control required" name="writing" id="writing" value="" >
      </div>
    </div>




    <div class="form-group">
      <label class="col-sm-3 control-label" for="cc-via-online">Reading</label>
      <div class="col-sm-3">
        <input type="number" class="form-control required" name="reading" id="reading" value="">
      </div>
      <label class="col-sm-2 control-label" for="cc-via-online">Speaking</label>
      <div class="col-sm-3">
        <input type="number" class="form-control required" name="speaking" id="speaking" value="">
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="cc-via-online" style="text-align:left;">Have you completed a TOEFL? </label>
    <div class="col-sm-3">
      <input type="radio" name="have_toefl" id="toefl_yes" value="1" > Yes &nbsp;&nbsp;&nbsp;
      <input type="radio" name="have_toefl" id="toefl_no" value="0" checked=""> No
    </div>
    <div class="col-sm-6">
      <div id="div_toefl" style="display:none;">
        <label class="col-sm-5 control-label" for="cc-via-online" style="text-align:left;">Total TOEFL iBT Score? </label>
        <div class="col-sm-5">
          <input type="text" class="form-control number" name="txt_toefl" id="txt_toefl" value="" >
        </div>
      </div>
    </div>

  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label"  style="text-align:left;">Have you completed a PTE? </label>
    <div class="col-sm-3">
      <input type="radio" name="have_pte" id="pte_yes" value="1" > Yes &nbsp;&nbsp;&nbsp;
      <input type="radio" name="have_pte" id="pte_no" value="0" checked=""> No
    </div>
    <div class="col-sm-6">
      <div id="div_pte" style="display:none;">
        <label class="col-sm-5 control-label" for="txt_pte" style="text-align:left;">Total PTE Score? </label>
        <div class="col-sm-5">
          <input type="text" class="form-control number" name="txt_pte" id="txt_pte" value="" >
        </div>
      </div>
    </div>

  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label"  style="text-align:left;">Have you completed a SAT? </label>
    <div class="col-sm-3">
      <input type="radio" name="have_sat" id="sat_yes" value="1" > Yes &nbsp;&nbsp;&nbsp;
      <input type="radio" name="have_sat" id="sat_no" value="0" checked=""> No
    </div>
    <div class="col-sm-6">
      <div id="div_sat" style="display:none;">
        <label class="col-sm-5 control-label" for="txt_sat" style="text-align:left;">Total SAT Score? </label>
        <div class="col-sm-5">
          <input type="text" class="form-control number" name="txt_sat" id="txt_sat" value="" >
        </div>
      </div>
    </div>

  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label"  style="text-align:left;">Have you completed a GRE? </label>
    <div class="col-sm-3">
      <input type="radio" name="have_gre" id="gre_yes" value="1" > Yes &nbsp;&nbsp;&nbsp;
      <input type="radio" name="have_gre" id="gre_no" value="0" checked=""> No
    </div>
    <div class="col-sm-6">
      <div id="div_gre" style="display:none;">
        <label class="col-sm-5 control-label" for="txt_gre" style="text-align:left;">Total GRE Score? </label>
        <div class="col-sm-5">
          <input type="text" class="form-control number" name="txt_gre" id="txt_gre" value="" >
        </div>
      </div>
    </div>

  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label"  style="text-align:left;">Have you completed a GMAT? </label>
    <div class="col-sm-3">
      <input type="radio" name="have_gmat" id="gmat_yes" value="1" > Yes &nbsp;&nbsp;&nbsp;
      <input type="radio" name="have_gmat" id="gmat_no" value="0" checked=""> No
    </div>
    <div class="col-sm-6">
      <div id="div_gmat" style="display:none;">
        <label class="col-sm-5 control-label" for="txt_gmat" style="text-align:left;">Total GMAT Score? </label>
        <div class="col-sm-5">
          <input type="text" class="form-control number" name="txt_gmat" id="txt_gmat" value="" >
        </div>
      </div>
    </div>

  </div>



  <div class="form-group">
    <label class="col-sm-3 control-label" for="cc-via-online" style="text-align:left;">Qualifactions</label>
    <div class="col-sm-6">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-12">
      <table class="table table-bordered table-striped mb-none" id="">
        <thead>
          <tr>
            <th>Qualification </th>
            <th>Institution </th>
            <th>Country</th>
            <th>Year of commencement</th>
            <th>Year of Completion</th>
            <th>Obtained (%)</th>
            <th>Document attachment</th>
          </tr>
        </thead>
        <tbody>
         <tr>
           <th><input type="text" name="qualifaction[]" class="form-control " id="qualifaction"> </th>
           <th><input type="text" name="institution[]" class="form-control " id="institution">  </th>
           <th> <select name="country[]" class="form-control" data-plugin-selectTwo style="width:200px;">
             <option value="">Select</option>
             <?php
             foreach ($countries as $row) {
               ?>
               <option value="<?php echo $row->country_name;?>" ><?php echo $row->country_name;?></option>
               <?php
             }
             ?>
           </select> </th>
           <th> <select name="commence_date[]" class="form-control " data-plugin-selectTwo> 
            <option value="">Select</option>
            <?php 
            for($k = 1950; $k <= date("Y");$k++){
              ?>
              <option value="<?php echo $k;?>" >
                <?php echo $k;?>
              </option>
              <?php
            }?>
          </select> </th>
          <th> 
            <select name="complete_date[]" class="form-control " data-plugin-selectTwo> 
              <option value="">Select</option>
              <?php 
              for($k = 1950; $k <= date("Y");$k++){
                ?>
                <option value="<?php echo $k;?>" >
                  <?php echo $k;?>
                </option>
                <?php
              }?>
            </select>
          </th>
          <th><input type="text" name="percentage[]" class="form-control " id="percentage"></th>
          <th><input type="checkbox" name="is_attached1" id="is_attached"></th>
        </tr>
        <tr>
         <th><input type="text" name="qualifaction[]" class="form-control " id="qualifaction"> </th>
         <th><input type="text" name="institution[]" class="form-control " id="institution">  </th>
         <th> <select name="country[]" class="form-control" data-plugin-selectTwo style="width:200px;">
           <option value="">Select</option>
           <?php
           foreach ($countries as $row) {
             ?>
             <option value="<?php echo $row->country_name;?>"  ><?php echo $row->country_name;?></option>
             <?php
           }
           ?>
         </select> </th>
         <th> <select name="commence_date[]" class="form-control " data-plugin-selectTwo> 
          <option value="">Select</option>
          <?php 
          for($k = 1950; $k <= date("Y");$k++){
            ?>
            <option value="<?php echo $k;?>">
              <?php echo $k;?>
            </option>
            <?php
          }?>
        </select> </th>
        <th> 
          <select name="complete_date[]" class="form-control " data-plugin-selectTwo> 
            <option value="">Select</option>
            <?php 
            for($k = 1950; $k <= date("Y");$k++){
              ?>
              <option value="<?php echo $k;?>" >
                <?php echo $k;?>
              </option>
              <?php
            }?>
          </select>
        </th>
        <th><input type="text" name="percentage[]" class="form-control " id="percentage"></th>
        <th><input type="checkbox" name="is_attached1" id="is_attached"></th>
      </tr>
      <tr>
       <th><input type="text" name="qualifaction[]" class="form-control " id="qualifaction"> </th>
       <th><input type="text" name="institution[]" class="form-control " id="institution">  </th>
       <th> <select name="country[]" class="form-control" data-plugin-selectTwo style="width:200px;">
         <option value="">Select</option>
         <?php
         foreach ($countries as $row) {
           ?>
           <option value="<?php echo $row->country_name;?>" ><?php echo $row->country_name;?></option>
           <?php
         }
         ?>
       </select> </th>
       <th> <select name="commence_date[]" class="form-control " data-plugin-selectTwo> 
        <option value="">Select</option>
        <?php 
        for($k = 1950; $k <= date("Y");$k++){
          ?>
          <option value="<?php echo $k;?>" >
            <?php echo $k;?>
          </option>
          <?php
        }?>
      </select> </th>
      <th> 
        <select name="complete_date[]" class="form-control " data-plugin-selectTwo> 
          <option value="">Select</option>
          <?php 
          for($k = 1950; $k <= date("Y");$k++){
            ?>
            <option value="<?php echo $k;?>" >
              <?php echo $k;?>
            </option>
            <?php
          }?>
        </select>
      </th>
      <th><input type="text" name="percentage[]" class="form-control " id="percentage"></th>
      <th><input type="checkbox" name="is_attached1" id="is_attached"></th>
    </tr>
  </tbody>
</table>
</div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label" for="cc-via-online" style="text-align:left;">Experience</label>
  <div class="col-sm-6">
  </div>
</div>
<div class="form-group">
  <div class="col-sm-12">
    <table class="table table-bordered table-striped mb-none" id="">
      <thead>
        <tr>
          <th>Experience </th>
          <th>Institution </th>
          <th>Position </th>
          <th>Country</th>
          <th>Year of commencement</th>
          <th>Year of Completion</th>
          <th>Document attachment</th>
        </tr>
      </thead>
      <tbody>
       <tr>
         <th><input type="text" name="experience[]" class="form-control"> </th>
         <th><input type="text" name="e_institution[]" class="form-control">  </th>
         <th><input type="text" name="e_position[]" class="form-control">  </th>
         <th> <select name="e_country[]" class="form-control" style="width:200px;" data-plugin-selectTwo>
           <option value="">Select</option>
           <?php
           foreach ($countries as $row) {
             ?>
             <option value="<?php echo $row->country_name;?>" ><?php echo $row->country_name;?></option>
             <?php
           }
           ?>
         </select> </th>
         <th> <select name="e_commence_date[]" class="form-control " data-plugin-selectTwo> 
          <option value="">Select</option>
          <?php 
          for($k = 1950; $k <= date("Y");$k++){
            ?>
            <option value="<?php echo $k;?>" >
              <?php echo $k;?>
            </option>
            <?php
          }?>
        </select>
      </th>
      <th> <select name="e_complete_date[]" class="form-control " data-plugin-selectTwo> 
        <option value="">Select</option>
        <?php 
        for($k = 1950; $k <= date("Y");$k++){
          ?>
          <option value="<?php echo $k;?>" >
            <?php echo $k;?>
          </option>
          <?php
        }?>
      </select></th>
      <th><input type="checkbox" name="e_is_attached1"></th>
    </tr>
    <tr>
     <th><input type="text" name="experience[]" class="form-control"> </th>
     <th><input type="text" name="e_institution[]" class="form-control">  </th>
     <th><input type="text" name="e_position[]" class="form-control">  </th>
     <th> <select name="e_country[]" class="form-control" style="width:200px;" data-plugin-selectTwo>
       <option value="">Select</option>
       <?php
       foreach ($countries as $row) {
         ?>
         <option value="<?php echo $row->country_name;?>" ><?php echo $row->country_name;?></option>
         <?php
       }
       ?>
     </select> </th>
     <th> <select name="e_commence_date[]" class="form-control " data-plugin-selectTwo> 
      <option value="">Select</option>
      <?php 
      for($k = 1950; $k <= date("Y");$k++){
        ?>
        <option value="<?php echo $k;?>" >
          <?php echo $k;?>
        </option>
        <?php
      }?>
    </select>
  </th>
  <th> <select name="e_complete_date[]" class="form-control " data-plugin-selectTwo> 
    <option value="">Select</option>
    <?php 
    for($k = 1950; $k <= date("Y");$k++){
      ?>
      <option value="<?php echo $k;?>" >
        <?php echo $k;?>
      </option>
      <?php
    }?>
  </select></th>
  <th><input type="checkbox" name="e_is_attached1"></th>
</tr>
<tr>
 <th><input type="text" name="experience[]" class="form-control"> </th>
 <th><input type="text" name="e_institution[]" class="form-control">  </th>
 <th><input type="text" name="e_position[]" class="form-control">  </th>
 <th> <select name="e_country[]" class="form-control" style="width:200px;" data-plugin-selectTwo>
   <option value="">Select</option>
   <?php
   foreach ($countries as $row) {
     ?>
     <option value="<?php echo $row->country_name;?>" ><?php echo $row->country_name;?></option>
     <?php
   }
   ?>
 </select> </th>
 <th> <select name="e_commence_date[]" class="form-control " data-plugin-selectTwo> 
  <option value="">Select</option>
  <?php 
  for($k = 1950; $k <= date("Y");$k++){
    ?>
    <option value="<?php echo $k;?>" >
      <?php echo $k;?>
    </option>
    <?php
  }?>
</select>
</th>
<th> <select name="e_complete_date[]" class="form-control " data-plugin-selectTwo> 
  <option value="">Select</option>
  <?php 
  for($k = 1950; $k <= date("Y");$k++){
    ?>
    <option value="<?php echo $k;?>" >
      <?php echo $k;?>
    </option>
    <?php
  }?>
</select></th>
<th><input type="checkbox" name="e_is_attached1"></th>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<input type="hidden" name="lead_id" value="<?php echo $lead->lead_id??0;?>">
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
      <a id="link_next">Next <i class="fa fa-angle-right"></i></a>
    </li>

  </ul>
  <a href="<?php echo base_url("dashboard/student");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
</div>
</section>
</div>
</div>
<!-- end: page -->
</section>
</div>
</section>
<?php $this->load->view("lms/add_purpose");?>
<script type="text/javascript">
  $(document).ready(function(){

    $(document).on("change","#profile_pic",function(){ 
			var file_data = $(this).prop('files')[0];
			var form_data = new FormData();
			form_data.append('file', file_data);

			$.ajax({
				url: '<?php echo base_url("");?>company/upload_file_project', 
				dataType: 'text', 
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (response) {
					$('#post_img_profile').html('<img src="<?php echo SITE_URL."uploads/document/";?>/'+response+'" style="width:100%"><a href="javascript:void(0);" id="link_remove_image" class="list-btn btn btn-primary">Remove</a>');
					$('#txt_profile_pic').val(response);
				},
				error: function (response) {
					$('#post_img_profile').html(response); 
				}
			});
		});

    $(document).on("click","#link_remove_image",function(){
			if(!confirm("Are you sure to remove this image?"))
				return false;
			$("#post_img_profile").html("");
      $('#txt_profile_pic').val("");
		});
    $("#email").blur(function(){
      var email = $(this).val(); 
      $.ajax({
        url: '<?php echo base_url() ?>student/checkEmail',
        type: "POST",
        data: "email=" + email,
        success: function(data) { 
          if(data != ""){
            $("#error_email").html(data);
          }else{
            $("#error_email").html("");
          }
          $("#error_email").show();
        }        
      });
    });

    $("#username").blur(function(){
      var username = $(this).val(); 
      $.ajax({
        url: '<?php echo base_url() ?>student/checkUsername',
        type: "POST",
        data: "username=" + username,
        success: function(data) { 
          if(data != ""){
            $("#error_username").html(data);
          }else{
            $("#error_username").html("");
          }
          $("#error_username").show();
        }        
      });
    });

    $("#link_next").click(function(){ 
      $("#email").trigger('blur');
    });

    $("#link_user").click(function(){ 
      $("#form_user_model").modal();
    });

    $("#link_about").click(function(){ 
      $("#form_about_model").modal();
    });

    $("#form_user").validate();
    $("#form_about").validate();

    $("#toefl_yes").click(function(){
      $("#div_toefl").show();
      $("#txt_toefl").addClass("required");
    });

    $("#toefl_no").click(function(){
      $("#div_toefl").hide();
      $("#txt_toefl").removeClass("required");
    });

    $("#pte_yes").click(function(){
      $("#div_pte").show();
      $("#txt_pte").addClass("required");
    });

    $("#pte_no").click(function(){
      $("#div_pte").hide();
      $("#txt_pte").removeClass("required");
    });

    $("#sat_yes").click(function(){
      $("#div_sat").show();
      $("#txt_sat").addClass("required");
    });

    $("#sat_no").click(function(){
      $("#div_sat").hide();
      $("#txt_sat").removeClass("required");
    });

    $("#gre_yes").click(function(){
      $("#div_gre").show();
      $("#txt_gre").addClass("required");
    });

    $("#gre_no").click(function(){
      $("#div_gre").hide();
      $("#txt_gre").removeClass("required");
    });

    $("#gmat_yes").click(function(){
      $("#div_gmat").show();
      $("#txt_gmat").addClass("required");
    });

    $("#gmat_no").click(function(){
      $("#div_gmat").hide();
      $("#txt_gmat").removeClass("required");
    });

    $(".link_finish").click(function(){
     $("#form_student").submit();
   });
   // $("#div_ielts").hide();
   $("#ielts_no").click(function(){
    $("#div_ielts").hide();
    $("#listening").removeClass("required");
    $("#writing").removeClass("required");
    $("#speaking").removeClass("required");
    $("#reading").removeClass("required");
  });

   $("#ielts_yes").click(function(){
    $("#div_ielts").show();
    $("#listening").addClass("required");
    $("#writing").addClass("required");
    $("#speaking").addClass("required");
    $("#reading").addClass("required");
  });

var num = 1;
   $("#link_add_doc").click(function(){
    num = num + 1;
    $.ajax({
      url: '<?php echo base_url() ?>student/get_docRow',
      type: "POST",
      data: "num=" + num,
      success: function(data) { 
        if(data != ""){
          $("#div_document").append(data);
        }
      }        
    });
  });
   $(document).on("click",".link_remove",function(){
    var id = $(this).attr("rel");
    $(this).parent().parent().remove();
  });

  
 });

</script>

