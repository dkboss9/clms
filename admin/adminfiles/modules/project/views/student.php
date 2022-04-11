<!-- start: page -->
<section class="panel">
    <div class="panel-body case-body">
    <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>
<?php $this->load->view("tab");?>
        <div class="migrate-menu">
            <div class="row">
                <div class="col-sm-12">

                    <div>
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                        <input type="hidden" name="enroll_id" id="enroll_id" value="<?php echo $enroll_id;?>">
                    </div>
                    <section class="panel form-wizard" id="w4">

                    <div class="panel-body">
                        <div class="wizard-progress wizard-progress-lg">
                            <div class="steps-progress">
                                <div class="progress-indicator"></div>
                            </div>
                            <ul class="wizard-steps">
                                <ul class="wizard-steps">
                                    <li class="active">
                                        <a href="#w4-account" data-toggle="tab"
                                            aria-expanded="true"><span>1</span>Personal Info</a>
                                    </li>
                                    <li class="">
                                        <a href="#w4-profile" data-toggle="tab"
                                            aria-expanded="false"><span>2</span>Doccuments</a>
                                    </li>
                                    <li>
                                        <a href="#w4-billing" data-toggle="tab"><span>3</span>Qualifications</a>
                                    </li>

                                </ul>
                            </ul>
                        </div>

                        <form id="form" method="post" action="<?php echo base_url("student/edit");?>"
                            enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
                            <div class="tab-content">
                                <div id="w4-account" class="tab-pane active">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="fname">First Name</label>
                                        <div class="col-md-3">
                                            <input type="text" name="fname" id="fname"
                                                value="<?php echo $result->first_name;?>" class="form-control "
                                                required />
                                            <input type="hidden" name="role" id="role" value="3">
                                        </div>
                                        <label class="col-md-3 control-label" for="lname">Last Name</label>
                                        <div class="col-md-3">
                                            <input type="text" name="lname" id="lname"
                                                value="<?php echo $result->last_name;?>" class="form-control"
                                                required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Email</label>
                                        <div class="col-md-3">
                                            <input type="email" name="email" id="email"
                                                value="<?php echo $result->email;?>" class="form-control" required />
                                            <?php if(form_error("email")) echo form_error("email");?>
                                        </div>

                                        <label class="col-md-3 control-label" for="mobile">Mobile</label>
                                        <div class="col-md-3">
                                            <input type="text" name="mobile" id="mobile"
                                                value="<?php echo $result->mobile;?>" class="form-control number" />
                                        </div>
                                    </div>


                                   

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="dob">DOB</label>
                                        <div class="col-md-3">
                                            <input type="text" data-plugin-datepicker="" name="dob" id="dob"
                                                value="<?php echo $result->dob;?>" class="form-control" autocomplete="off"/>
                                        </div>

                                        <label class="col-md-3 control-label"> Photo </label>
  <div class="col-md-3">
    <input type="file" name="profile_pic" id="profile_pic" class="form-control">
    <input type="hidden" name="txt_profile_pic" id="txt_profile_pic" value="<?php echo $result->picture;?>">
  </div>
  <div class="col-md-1" id="post_img_profile">
  <img src="<?php echo SITE_URL."uploads/document/".$result->picture;?>" style="width:100%"><a href="javascript:void(0);" id="link_remove_image" class="list-btn btn btn-primary">Remove</a>
  </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="passport_no">Passport No</label>
                                        <div class="col-md-3">
                                            <input type="text" name="passport_no" id="passport_no"
                                                value="<?php echo $result->passport_no;?>" class="form-control" />
                                        </div>
                                        <label class="col-md-3 control-label" for="lname">Phone</label>
                                        <div class="col-md-3">
                                            <input type="text" name="phone" id="phone"
                                                value="<?php echo $result->phone;?>" class="form-control  number" />
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="user">Referral</label>
                                        <div class="col-md-3">
                                            <select name="referral" id="user" class="form-control mb-md "
                                                data-plugin-selectTwo>
                                                <option value="">Select</option>
                                                <?php 
    foreach($users as $user){
      ?>
                                                <option value="<?php echo $user->id;?>"
                                                    <?php if($user->id == $result->referral) echo 'selected="selected"'; ?>>
                                                    <?php echo $user->first_name.' '.$user->last_name;?></option>
                                                <?php
    }
    ?>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="javascript:void(0);" id="link_user"><i
                                                    class="glyphicon glyphicon-plus"></i></a>
                                        </div>
                                        <label class="col-md-2 control-label" for="address">Address</label>
                                        <div class="col-md-3">
                                            <input type="text" name="address" id="address"
                                                value="<?php echo $result->address;?>" class="form-control" />
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="sex">Sex</label>
                                        <div class="col-md-3">
                                            <select name="sex" class="form-control " data-plugin-selectTwo>
                                                <option value="">Select</option>
                                                <option value="Male"
                                                    <?php if($result->sex == "Male") echo 'selected="selected"';?>>Male
                                                </option>
                                                <option value="Female"
                                                    <?php if($result->sex == "Female") echo 'selected="selected"';?>>
                                                    Female</option>
                                            </select>
                                        </div>
                                        <label class="col-md-3 control-label" for="is_married">Marital Status</label>
                                        <div class="col-md-3">
                                            <select name="is_married" class="form-control " data-plugin-selectTwo>
                                                <option value="">Select</option>
                                                <option value="Single"
                                                    <?php if($result->is_married == "Single") echo 'selected="selected"';?>>
                                                    Single</option>
                                                <option value="Married"
                                                    <?php if($result->is_married == "Married") echo 'selected="selected"';?>>
                                                    Married</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-2 control-label">How do you know about us?</label>
                                        <div class="col-md-3">
                                            <select name="about_us" id="about_us" class="form-control mb-md"
                                                data-plugin-selectTwo>
                                                <option value="">Select</option>
                                                <?php 
      foreach($about_us as $row){
        ?>
                                                <option
                                                    <?php if($row->threatre_id == $result->about_us) echo 'selected="selected"';?>
                                                    value="<?php echo $row->threatre_id;?>"><?php echo $row->name;?>
                                                </option>
                                                <?php
      }
      ?>

                                            </select>

                                        </div>
                                        <div class="col-md-1">
                                            <a href="javascript:void(0);" id="link_about"><i
                                                    class="glyphicon glyphicon-plus"></i></a>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div id="w4-profile" class="tab-pane">

<?php
$documents = $this->studentmodel->getDoccuments($student_id);
?>
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
        <?php 
        $i = 1;
        foreach ($documents as $docs) {
        ?>
        <tr>
            <td>
                <?php
                foreach ($doc_type as $row) {
                ?>
                <?php if($row->type_id == $docs->doc_type) echo $row->type_name;?>
                <?php
                }
                ?>
            </td>
            <td> <a href="<?php echo SITE_URL."uploads/student_documents/".$docs->doc_name; ?>"
                    target="_blank"><?php echo $docs->doc_name;?></a></td>
            <td><?php echo $docs->doc_desc;?></td>
            <td>
                <a href="javascript:void(0);" class="link_remove" rel="<?php echo $i;?>"
                    docid="<?php echo $docs->id;?>"><i class="fa fa-trash-o"
                        aria-hidden="true"></i></a>
            </td>
        </tr>
        <?php }?>
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
                                        <label class="col-sm-3 control-label" for="w4-cc">Have you completed an IELTS
                                            test in the last 2 years? </label>
                                        <div class="col-sm-6">
                                            <input type="radio" name="have_ielts" id="ielts_yes" value="1"
                                                <?php if($result->ielts == '1') echo 'checked="checked"'; ?>> Yes
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="have_ielts" id="ielts_no" value="0"
                                                <?php if($result->ielts == '0') echo 'checked="checked"'; ?>> No
                                        </div>
                                    </div>
                                    <div id="div_ielts"
                                        <?php if($result->ielts == '0') echo 'style="display:none;"'; ?>>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="cc-via-online">Listening</label>
                                            <div class="col-sm-3">
                                                <input type="number"
                                                    class="form-control <?php if($result->ielts == '1') echo 'required'; ?>"
                                                    name="listening" id="listening"
                                                    value="<?php echo $result->listening;?>">
                                            </div>
                                            <label class="col-sm-2 control-label" for="cc-via-online">Writing</label>
                                            <div class="col-sm-3">
                                                <input type="number"
                                                    class="form-control <?php if($result->ielts == '1') echo 'required'; ?>"
                                                    name="writing" id="writing" value="<?php echo $result->writing;?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="cc-via-online">Reading</label>
                                            <div class="col-sm-3">
                                                <input type="number"
                                                    class="form-control <?php if($result->ielts == '1') echo 'required'; ?>"
                                                    name="reading" id="reading" value="<?php echo $result->reading;?>">
                                            </div>
                                            <label class="col-sm-2 control-label" for="cc-via-online">Speaking</label>
                                            <div class="col-sm-3">
                                                <input type="number"
                                                    class="form-control <?php if($result->ielts == '1') echo 'required'; ?>"
                                                    name="speaking" id="speaking"
                                                    value="<?php echo $result->speaking;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"> </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="cc-via-online"
                                            style="text-align:left;">Have you completed a TOEFL? </label>
                                        <div class="col-sm-3">
                                            <input type="radio" name="have_toefl" id="toefl_yes" value="1"
                                                <?php if($result->toefl == 1) echo 'checked="checked"';?>> Yes
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="have_toefl" id="toefl_no" value="0"
                                                <?php if($result->toefl == 0) echo 'checked="checked"';?>> No
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="div_toefl"
                                                <?php if($result->toefl == 0) echo 'style="display:none;"';?>>
                                                <label class="col-sm-5 control-label" for="cc-via-online"
                                                    style="text-align:left;">Total TOEFL iBT Score? </label>
                                                <div class="col-sm-5">
                                                    <input type="text"
                                                        class="form-control number <?php if($result->toefl == 1) echo 'required';?>"
                                                        name="txt_toefl" id="txt_toefl"
                                                        value="<?php echo $result->toefl_score;?>">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" style="text-align:left;">Have you
                                            completed a PTE? </label>
                                        <div class="col-sm-3">
                                            <input type="radio" name="have_pte" id="pte_yes" value="1"
                                                <?php if($result->pte == 1) echo 'checked="checked"';?>> Yes
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="have_pte" id="pte_no" value="0"
                                                <?php if($result->pte == 0) echo 'checked="checked"';?>> No
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="div_pte"
                                                <?php if($result->pte == 0) echo 'style="display:none;"';?>>
                                                <label class="col-sm-5 control-label" for="txt_pte"
                                                    style="text-align:left;">Total PTE Score? </label>
                                                <div class="col-sm-5">
                                                    <input type="text"
                                                        class="form-control number <?php if($result->pte == 1) echo 'required';?>"
                                                        name="txt_pte" id="txt_pte"
                                                        value="<?php echo $result->pte_score;?>">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" style="text-align:left;">Have you
                                            completed a SAT? </label>
                                        <div class="col-sm-3">
                                            <input type="radio" name="have_sat" id="sat_yes" value="1"
                                                <?php if($result->sat == 1) echo 'checked="checked"';?>> Yes
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="have_sat" id="sat_no" value="0"
                                                <?php if($result->sat == 0) echo 'checked="checked"';?>> No
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="div_sat"
                                                <?php if($result->pte == 0) echo 'style="display:none;"';?>>
                                                <label class="col-sm-5 control-label" for="txt_sat"
                                                    style="text-align:left;">Total SAT Score? </label>
                                                <div class="col-sm-5">
                                                    <input type="text"
                                                        class="form-control number <?php if($result->sat == 1) echo 'required';?>"
                                                        name="txt_sat" id="txt_sat"
                                                        value="<?php echo $result->sat_score;?>">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" style="text-align:left;">Have you
                                            completed a GRE? </label>
                                        <div class="col-sm-3">
                                            <input type="radio" name="have_gre" id="gre_yes" value="1"
                                                <?php if($result->gre == 1) echo 'checked="checked"';?>> Yes
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="have_gre" id="gre_no" value="0"
                                                <?php if($result->gre == 0) echo 'checked="checked"';?>> No
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="div_gre"
                                                <?php if($result->gre == 0) echo 'style="display:none;"';?>>
                                                <label class="col-sm-5 control-label" for="txt_gre"
                                                    style="text-align:left;">Total GRE Score? </label>
                                                <div class="col-sm-5">
                                                    <input type="text"
                                                        class="form-control number <?php if($result->gre == 1) echo 'required';?>"
                                                        name="txt_gre" id="txt_gre"
                                                        value="<?php echo $result->gre_score;?>">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" style="text-align:left;">Have you
                                            completed a GMAT? </label>
                                        <div class="col-sm-3">
                                            <input type="radio" name="have_gmat" id="gmat_yes" value="1"
                                                <?php if($result->gmat == 1) echo 'checked="checked"';?>> Yes
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="have_gmat" id="gmat_no" value="0"
                                                <?php if($result->gmat == 0) echo 'checked="checked"';?>> No
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="div_gmat"
                                                <?php if($result->gmat == 0) echo 'style="display:none;"';?>>
                                                <label class="col-sm-5 control-label" for="txt_gmat"
                                                    style="text-align:left;">Total GMAT Score? </label>
                                                <div class="col-sm-5">
                                                    <input type="text"
                                                        class="form-control number <?php if($result->gmat == 1) echo 'required';?>"
                                                        name="txt_gmat" id="txt_gmat"
                                                        value="<?php echo $result->gmat_score;?>">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <?php
  $qualifications = $this->studentmodel->getQualifications($result->id);
  ?>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="cc-via-online"
                                            style="text-align:left;">Qualifactions</label>
                                        <div class="col-sm-6">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered table-striped mb-none" id="">
                                                <thead>
                                                    <tr>
                                                        <th>Qualification </th>
                                                        <th>Institution </th>
                                                        <th>Country</th>
                                                        <th>Year of commencement</th>
                                                        <th>Year of Completion</th>
                                                        <th>Obtained (%)</th>
                                                        <th>document attachment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
          $i = 1;
          foreach ($qualifications as $qual) {
            ?>
                                                    <tr>
                                                        <th><input type="text" name="qualifaction[]"
                                                                class="form-control " id="qualifaction"
                                                                value="<?php echo $qual->qualification_name;?>"> </th>
                                                        <th><input type="text" name="institution[]"
                                                                class="form-control " id="institution"
                                                                value="<?php echo $qual->institution_name;?>"> </th>
                                                        <th>
                                                            <select name="country[]" class="form-control"
                                                                data-plugin-selectTwo style="width:200px;">
                                                                <option value="">Select</option>
                                                                <?php
               foreach ($countries as $row) {
                 ?>
                                                                <option value="<?php echo $row->country_name;?>"
                                                                    <?php if($row->country_name == $qual->country) echo 'selected="selected"';?>>
                                                                    <?php echo $row->country_name;?></option>
                                                                <?php
               }
               ?>
                                                            </select>
                                                        </th>
                                                        <th>
                                                            <select name="commence_date[]" class="form-control "
                                                                data-plugin-selectTwo>
                                                                <?php 
              for($k = 1950; $k <= date("Y");$k++){
                ?>
                                                                <option value="<?php echo $k;?>"
                                                                    <?php if($qual->commence_date == $k) echo 'selected="selected"';?>>
                                                                    <?php echo $k;?>
                                                                </option>
                                                                <?php
              }?>
                                                            </select>
                                                        </th>
                                                        <th>
                                                            <select name="complete_date[]" class="form-control "
                                                                data-plugin-selectTwo>
                                                                <?php 
              for($k = 1950; $k <= date("Y");$k++){
                ?>
                                                                <option value="<?php echo $k;?>"
                                                                    <?php if($qual->complete_year == $k) echo 'selected="selected"';?>>
                                                                    <?php echo $k;?>
                                                                </option>
                                                                <?php
              }?>
                                                            </select>
                                                        </th>
                                                        <th><input type="text" name="percentage[]" class="form-control "
                                                                id="percentage" value="<?php echo $qual->percent;?>">
                                                        </th>
                                                        <th><input type="checkbox" name="is_attached<?php echo $i;?>"
                                                                id="is_attached"
                                                                <?php if($qual->doc_attached == '1') echo 'checked="checked"';?>>
                                                        </th>
                                                    </tr>
                                                    <?php
        $i++;
      }
      for($j = $i; $j<=3; $j++){
        ?>
                                                    <tr>
                                                        <th><input type="text" name="qualifaction[]"
                                                                class="form-control"> </th>
                                                        <th><input type="text" name="institution[]"
                                                                class="form-control"> </th>
                                                        <th> <select name="country[]" class="form-control"
                                                                data-plugin-selectTwo style="width:200px;">
                                                                <option value="">Select</option>
                                                                <?php
           foreach ($countries as $row) {
             ?>
                                                                <option value="<?php echo $row->country_name;?>">
                                                                    <?php echo $row->country_name;?></option>
                                                                <?php
           }
           ?>
                                                            </select></th>
                                                        <th>
                                                            <select name="commence_date[]" class="form-control "
                                                                data-plugin-selectTwo>
                                                                <option value="">Select</option>
                                                                <?php 
           for($k = 1950; $k <= date("Y");$k++){
            ?>
                                                                <option value="<?php echo $k;?>">
                                                                    <?php echo $k;?>
                                                                </option>
                                                                <?php
          }?>
                                                            </select>
                                                        </th>
                                                        <th>
                                                            <select name="complete_date[]" class="form-control "
                                                                data-plugin-selectTwo>
                                                                <option value="">Select</option>
                                                                <?php 
          for($k = 1950; $k <= date("Y");$k++){
            ?>
                                                                <option value="<?php echo $k;?>">
                                                                    <?php echo $k;?>
                                                                </option>
                                                                <?php
          }?>
                                                            </select>
                                                        </th>
                                                        <th><input type="text" name="percentage[]" class="form-control">
                                                        </th>
                                                        <th><input type="checkbox" name="is_attached<?php echo $j;?>">
                                                        </th>
                                                    </tr>
                                                    <?php
  }
  ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="cc-via-online"
                                            style="text-align:left;">Experience</label>
                                        <div class="col-sm-6">
                                        </div>
                                    </div>
                                    <?php
$experiences = $this->studentmodel->getExperinces($result->id);
?>
                                    <div class="form-group">
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered table-striped mb-none" id="">
                                                <thead>
                                                    <tr>
                                                        <th>Experience </th>
                                                        <th>Institution </th>
                                                        <th>Position </th>
                                                        <th>Country</th>
                                                        <th>Year of commencement</th>
                                                        <th>Year of Completion</th>
                                                        <th>document attachment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
        $i = 1;
        foreach ($experiences as $exp) {
         ?>
                                                    <tr>
                                                        <th><input type="text" name="experience[]" class="form-control"
                                                                value="<?php echo $exp->experience_name;?>"> </th>
                                                        <th><input type="text" name="e_institution[]"
                                                                class="form-control"
                                                                value="<?php echo $exp->institution_name;?>"> </th>
                                                        <th><input type="text" name="e_position[]" class="form-control"
                                                                value="<?php echo $exp->position;?>"> </th>
                                                        <th>
                                                            <select name="e_country[]" class="form-control"
                                                                style="width:200px;" data-plugin-selectTwo>
                                                                <option value="">Select</option>
                                                                <?php
             foreach ($countries as $row) {
               ?>
                                                                <option value="<?php echo $row->country_name;?>"
                                                                    <?php if($exp->country == $row->country_name) echo 'selected="selected"';?>>
                                                                    <?php echo $row->country_name;?></option>
                                                                <?php
             }
             ?>
                                                            </select>
                                                        </th>
                                                        <th>
                                                            <select name="e_commence_date[]" class="form-control "
                                                                data-plugin-selectTwo>
                                                                <option value="">Select</option>
                                                                <?php 
            for($k = 1950; $k <= date("Y");$k++){
              ?>
                                                                <option value="<?php echo $k;?>"
                                                                    <?php if($k == $exp->commence_date) echo 'selected="selected"';?>>
                                                                    <?php echo $k;?>
                                                                </option>
                                                                <?php
            }?>
                                                            </select>

                                                        <th>
                                                            <select name="e_complete_date[]" class="form-control "
                                                                data-plugin-selectTwo>
                                                                <option value="">Select</option>
                                                                <?php 
            for($k = 1950; $k <= date("Y");$k++){
              ?>
                                                                <option value="<?php echo $k;?>"
                                                                    <?php if($exp->complete_year == $k) echo 'selected="selected"';?>>
                                                                    <?php echo $k;?>
                                                                </option>
                                                                <?php
            }?>
                                                            </select>
                                                        </th>
                                                        <th><input type="checkbox" name="e_is_attached<?php echo $i;?>"
                                                                <?php if($exp->doc_attached == '1') echo 'checked="checked"';?>>
                                                        </th>
                                                    </tr>
                                                    <?php
      $i++;
    }
    for($j = $i; $j<=3; $j++){
     ?>
                                                    <tr>
                                                        <th><input type="text" name="experience[]" class="form-control">
                                                        </th>
                                                        <th><input type="text" name="e_institution[]"
                                                                class="form-control"> </th>
                                                        <th><input type="text" name="e_position[]" class="form-control">
                                                        </th>
                                                        <th>
                                                            <select name="e_country[]" class="form-control"
                                                                data-plugin-selectTwo style="width:200px;">
                                                                <option value="">Select</option>
                                                                <?php
           foreach ($countries as $row) {
             ?>
                                                                <option value="<?php echo $row->country_name;?>">
                                                                    <?php echo $row->country_name;?></option>
                                                                <?php
           }
           ?>
                                                            </select>
                                                        </th>
                                                        <th> <select name="e_commence_date[]" class="form-control "
                                                                data-plugin-selectTwo>
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
                                                            <select name="e_complete_date[]" class="form-control "
                                                                data-plugin-selectTwo>
                                                                <option value="">Select</option>
                                                                <?php 
          for($k = 1950; $k <= date("Y");$k++){
            ?>
                                                                <option value="<?php echo $k;?>">
                                                                    <?php echo $k;?>
                                                                </option>
                                                                <?php
          }?>
                                                            </select>
                                                        </th>
                                                        <th><input type="checkbox" name="e_is_attached<?php echo $j;?>">
                                                        </th>
                                                    </tr>
                                                    <?php
  }
  ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>
                                <input type="hidden" name="is_case" value="1">
                                <input type="hidden" name="student_id" value="<?php echo $result->id;?>">
                        </form>
                    </div>
                    <div class="panel-footer">
                        <ul class="pager">
                            <li class="previous disabled">
                                <a><i class="fa fa-angle-left"></i> Previous</a>
                            </li>
                            <li class="pull-right">
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
        </div>
    </div>
</section>

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
     $("#form").submit();
   });
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
      var num = $(".div_row").length;
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
      if(!confirm("Are you sure to delete this record?"))
        return false;

      if($(this).attr("docid")){
        var docid = $(this).attr("docid");
        $.ajax({
          url: '<?php echo base_url() ?>student/delete_docRow',
          type: "POST",
          data: "docid=" + docid,
          success: function(data) { 
            if(data != ""){
              $("#div_document").append(data);
            }
          }        
        });
      }
      $(this).parent().parent().remove();
    });
  });

</script>
