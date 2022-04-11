<div id="form_customer_model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="width:600px;">
      <form class="form-horizontal form-bordered" id="form_customer" action="javascript:addCustomer();" method="post"
        enctype='multipart/form-data'>
        <div class="modal-content">
          <div class="tabs tabs-warning">
            <ul class="nav nav-tabs contact">
              <li class="active">
                <a aria-expanded="true" href="#addcontact" data-toggle="tab">Persional Info</a>
              </li>
              <li class="">
                <a aria-expanded="false" href="#billing" data-toggle="tab" id="link_billing">Documents</a>
              </li>
              <li class="">
                <a aria-expanded="false" href="#shipping" data-toggle="tab" id="link_shipping">Qualifications</a>
              </li>


            </ul>
            <div class="tab-content">
              <div id="addcontact" class="tab-pane active">

                <div class="form-group">
                  <label class="col-md-2 control-label" for="company_name">First Name</label>
                  <div class="col-md-4">
                    <input type="text" name="fname" id="fname" value="" class="form-control " required />
                  </div>
                  <label class="col-md-2 control-label" for="lname">Last Name</label>
                  <div class="col-md-4">
                    <input type="text" name="lname" id="lname" value="" class="form-control" required />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-2 control-label" for="company_name">Email</label>
                  <div class="col-md-4">
                    <input type="email" name="email" id="email" value="" class="form-control" required />
                    <label id="error_email" class="error"><?php echo form_error("email");?></label>
                  </div>
                  <label class="col-md-2 control-label" for="lname">Mobile</label>
                  <div class="col-md-4">
                    <input type="text" name="mobile" id="mobile" value="" class="form-control number" required />
                  </div>
                </div>

              

                <div class="form-group">
                  <label class="col-md-2 control-label" for="company_name">DOB</label>
                  <div class="col-md-4">
                    <input type="text" name="dob" id="dob" data-plugin-datepicker="" value="" class="form-control" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-2 control-label" for="company_name">Passport No</label>
                  <div class="col-md-4">
                    <input type="text" name="passport_no" id="passport_no" value="" class="form-control" />
                  </div>
                  <label class="col-md-2 control-label" for="lname">Phone</label>
                  <div class="col-md-4">
                    <input type="text" name="phone" id="phone_client" value="" class="form-control  number" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-2 control-label" for="company_name">Referral</label>
                  <div class="col-md-4">
                    <select name="referral" id="user_client" class="form-control mb-md " data-plugin-selectTwo>
                      <option value="">Select</option>
                      <?php 
                    foreach($users as $user){
                      ?>
                      <option value="<?php echo $user->id;?>"
                        <?php if($user->id == set_value("referral",@$lead->id)) echo 'selected="selected"'; ?>>
                        <?php echo $user->first_name.' '.$user->last_name;?></option>
                      <?php
                    }
                    ?>
                    </select>
                  </div>
                  <a href="javascript:void(0);" id="link_user_client"><i class="glyphicon glyphicon-plus"></i></a>
                </div>

                <div class="form-group">
                  <label class="col-md-2 control-label" for="company_name">Address</label>
                  <div class="col-md-4">
                    <input type="text" name="address" id="address" value="<?php echo set_value("address");?>"
                      class="form-control" />
                  </div>
                  <label class="col-md-2 control-label" for="lname">Sex</label>
                  <div class="col-md-4">
                    <select name="sex" class="form-control " data-plugin-selectTwo>
                      <option value="">Select</option>
                      <option value="Male" <?php if(set_value("sex") == "Male") echo 'selected="selected"';?>>Male
                      </option>
                      <option value="Female" <?php if(set_value("sex") == "Female") echo 'selected="selected"';?>>Female
                      </option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-2 control-label" for="company_name">How do you know about us?</label>
                  <div class="col-md-4">
                    <select name="about_us" id="about_us_client" class="form-control mb-md" data-plugin-selectTwo>
                      <option value="">Select</option>
                      <?php 
                      foreach($about_us as $row){
                        ?>
                      <option
                        <?php if($row->threatre_id == set_value("about_us",@$lead->about_us)) echo 'selected="selected"';?>
                        value="<?php echo $row->threatre_id;?>"><?php echo $row->name;?></option>
                      <?php
                      }
                      ?>

                    </select>
                  </div>
                  <div class="col-md-1">
                    <a href="javascript:void(0);" id="link_about_client"><i class="glyphicon glyphicon-plus"></i></a>
                  </div>
                  <div class="col-md-4">
                    <input type="checkbox" name="send_email" id="send_email" checked="" value="1"> Send Email / Sms
                  </div>
                </div>

              </div>
              <div id="billing" class="tab-pane ">


                <div class="form-group">
                  <label class="col-md-4 ">Document Type</label>
                  <label class="col-md-4 ">Document </label>
                  <label class="col-md-4 ">Description</label>
                </div>

                <div id="div_student_document">
                
                </div>
                <div class="form-group">
                  <label class="col-md-12 ">
                    <a href="javascript:void(0);" id="link_add_doc" class=" " rel="1"><i
                        class="glyphicon glyphicon-plus"></i></a>
                  </label>
                </div>




              </div>
              <div id="shipping" class="tab-pane ">

                <div class="form-group">
                  <label class="col-sm-8 control-label" for="w4-cc">Have you completed an IELTS test in the last 2
                    years? </label>
                  <div class="col-sm-3">
                    <input type="radio" name="have_ielts" id="ielts_yes" value="1" checked=""> Yes
                    <input type="radio" name="have_ielts" id="ielts_no" value="0"> No
                  </div>
                </div>

                <div id="div_ielts">
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="cc-via-online">Listening</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control required" name="listening" id="listening" value="">
                    </div>
                    <label class="col-sm-2 control-label" for="cc-via-online">Writing</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control required" name="writing" id="writing" value="">
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
                  <label class="col-sm-8 control-label" for="cc-via-online" style="text-align:left;">Have you completed
                    a TOEFL? </label>
                  <div class="col-sm-3">
                    <input type="radio" name="have_toefl" id="toefl_yes" value="1"> Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="have_toefl" id="toefl_no" value="0" checked=""> No
                  </div>
                  <div class="col-sm-6">
                    <div id="div_toefl" style="display:none;">
                      <label class="col-sm-5 control-label" for="cc-via-online" style="text-align:left;">Total TOEFL iBT
                        Score? </label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control number" name="txt_toefl" id="txt_toefl" value="">
                      </div>
                    </div>
                  </div>

                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" style="text-align:left;">Have you completed a PTE? </label>
                  <div class="col-sm-3">
                    <input type="radio" name="have_pte" id="pte_yes" value="1"> Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="have_pte" id="pte_no" value="0" checked=""> No
                  </div>
                  <div class="col-sm-6">
                    <div id="div_pte" style="display:none;">
                      <label class="col-sm-5 control-label" for="txt_pte" style="text-align:left;">Total PTE Score?
                      </label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control number" name="txt_pte" id="txt_pte" value="">
                      </div>
                    </div>
                  </div>

                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" style="text-align:left;">Have you completed a SAT? </label>
                  <div class="col-sm-3">
                    <input type="radio" name="have_sat" id="sat_yes" value="1"> Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="have_sat" id="sat_no" value="0" checked=""> No
                  </div>
                  <div class="col-sm-6">
                    <div id="div_sat" style="display:none;">
                      <label class="col-sm-5 control-label" for="txt_sat" style="text-align:left;">Total SAT Score?
                      </label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control number" name="txt_sat" id="txt_sat" value="">
                      </div>
                    </div>
                  </div>

                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" style="text-align:left;">Have you completed a GRE? </label>
                  <div class="col-sm-3">
                    <input type="radio" name="have_gre" id="gre_yes" value="1"> Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="have_gre" id="gre_no" value="0" checked=""> No
                  </div>
                  <div class="col-sm-6">
                    <div id="div_gre" style="display:none;">
                      <label class="col-sm-5 control-label" for="txt_gre" style="text-align:left;">Total GRE Score?
                      </label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control number" name="txt_gre" id="txt_gre" value="">
                      </div>
                    </div>
                  </div>

                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" style="text-align:left;">Have you completed a GMAT? </label>
                  <div class="col-sm-3">
                    <input type="radio" name="have_gmat" id="gmat_yes" value="1"> Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="have_gmat" id="gmat_no" value="0" checked=""> No
                  </div>
                  <div class="col-sm-6">
                    <div id="div_gmat" style="display:none;">
                      <label class="col-sm-5 control-label" for="txt_gmat" style="text-align:left;">Total GMAT Score?
                      </label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control number" name="txt_gmat" id="txt_gmat" value="">
                      </div>
                    </div>
                  </div>

                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="cc-via-online"
                    style="text-align:left;">Qualifactions</label>
                  <div class="col-sm-6">
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12" style="overflow-x:auto;">
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
                          <th><input type="text" name="qualifaction[]" class="form-control qualifaction" > </th>
                          <th><input type="text" name="institution[]" class="form-control institution"  > </th>
                          <th> <select name="country[]" class="form-control country" data-plugin-selectTwo style="width:200px;">
                              <option value="">Select</option>
                              <?php
             foreach ($countries as $row) {
               ?>
                              <option value="<?php echo $row->country_name;?>"><?php echo $row->country_name;?></option>
                              <?php
             }
             ?>
                            </select> </th>
                          <th> <select name="commence_date[]" class="form-control commence_date" data-plugin-selectTwo>
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
                            <select name="complete_date[]" class="form-control complete_date" data-plugin-selectTwo>
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
                          <th><input type="text" name="percentage[]" class="form-control percentage" ></th>
                          <th><input type="checkbox" name="is_attached1"  class="is_attached"></th>
                        </tr>
                        <tr>
                          <th><input type="text" name="qualifaction[]" class="form-control qualifaction"> </th>
                          <th><input type="text" name="institution[]" class="form-control institution" > </th>
                          <th> <select name="country[]" class="form-control country" data-plugin-selectTwo style="width:200px;">
                              <option value="">Select</option>
                              <?php
           foreach ($countries as $row) {
             ?>
                              <option value="<?php echo $row->country_name;?>"><?php echo $row->country_name;?></option>
                              <?php
           }
           ?>
                            </select> </th>
                          <th> <select name="commence_date[]" class="form-control commence_date" data-plugin-selectTwo>
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
                            <select name="complete_date[]" class="form-control complete_date" data-plugin-selectTwo>
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
                          <th><input type="text" name="percentage[]" class="form-control percentage" ></th>
                          <th><input type="checkbox" name="is_attached1" class="is_attached"></th>
                        </tr>
                        <tr>
                          <th><input type="text" name="qualifaction[]" class="form-control qualifaction" > </th>
                          <th><input type="text" name="institution[]" class="form-control institution" > </th>
                          <th> <select name="country[]" class="form-control country" data-plugin-selectTwo style="width:200px;">
                              <option value="">Select</option>
                              <?php
         foreach ($countries as $row) {
           ?>
                              <option value="<?php echo $row->country_name;?>"><?php echo $row->country_name;?></option>
                              <?php
         }
         ?>
                            </select> </th>
                          <th> <select name="commence_date[]" class="form-control commence_date" data-plugin-selectTwo>
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
                            <select name="complete_date[]" class="form-control complete_date" data-plugin-selectTwo>
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
                          <th><input type="text" name="percentage[]" class="form-control percentage"></th>
                          <th><input type="checkbox" name="is_attached1"  class="is_attached"></th>
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
                  <div class="col-sm-12" style="overflow-x:auto;">
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
                          <th><input type="text" name="experience[]" class="form-control experience"> </th>
                          <th><input type="text" name="e_institution[]" class="form-control e_institution"> </th>
                          <th><input type="text" name="e_position[]" class="form-control e_position"> </th>
                          <th> <select name="e_country[]" class="form-control e_country" style="width:200px;"
                              data-plugin-selectTwo>
                              <option value="">Select</option>
                              <?php
           foreach ($countries as $row) {
             ?>
                              <option value="<?php echo $row->country_name;?>"><?php echo $row->country_name;?></option>
                              <?php
           }
           ?>
                            </select> </th>
                          <th> <select name="e_commence_date[]" class="form-control e_commence_date" data-plugin-selectTwo>
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
                          <th> <select name="e_complete_date[]" class="form-control e_complete_date" data-plugin-selectTwo>
                              <option value="">Select</option>
                              <?php 
        for($k = 1950; $k <= date("Y");$k++){
          ?>
                              <option value="<?php echo $k;?>">
                                <?php echo $k;?>
                              </option>
                              <?php
        }?>
                            </select></th>
                          <th><input type="checkbox" name="e_is_attached1" class="e_is_attached"></th>
                        </tr>
                        <tr>
                          <th><input type="text" name="experience[]" class="form-control experience"> </th>
                          <th><input type="text" name="e_institution[]" class="form-control e_institution"> </th>
                          <th><input type="text" name="e_position[]" class="form-control e_position"> </th>
                          <th> <select name="e_country[]" class="form-control e_country" style="width:200px;"
                              data-plugin-selectTwo>
                              <option value="">Select</option>
                              <?php
       foreach ($countries as $row) {
         ?>
                              <option value="<?php echo $row->country_name;?>"><?php echo $row->country_name;?></option>
                              <?php
       }
       ?>
                            </select> </th>
                          <th> <select name="e_commence_date[]" class="form-control e_commence_date" data-plugin-selectTwo>
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
                          <th> <select name="e_complete_date[]" class="form-control e_complete_date" data-plugin-selectTwo>
                              <option value="">Select</option>
                              <?php 
    for($k = 1950; $k <= date("Y");$k++){
      ?>
                              <option value="<?php echo $k;?>">
                                <?php echo $k;?>
                              </option>
                              <?php
    }?>
                            </select></th>
                          <th><input type="checkbox" name="e_is_attached1" class="e_is_attached"></th>
                        </tr>
                        <tr>
                          <th><input type="text" name="experience[]" class="form-control experience"> </th>
                          <th><input type="text" name="e_institution[]" class="form-control e_institution"> </th>
                          <th><input type="text" name="e_position[]" class="form-control e_position"> </th>
                          <th> <select name="e_country[]" class="form-control" style="width:200px;"
                              data-plugin-selectTwo>
                              <option value="">Select</option>
                              <?php
   foreach ($countries as $row) {
     ?>
                              <option value="<?php echo $row->country_name;?>"><?php echo $row->country_name;?></option>
                              <?php
   }
   ?>
                            </select> </th>
                          <th> <select name="e_commence_date[]" class="form-control e_commence_date" data-plugin-selectTwo>
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
                          <th> <select name="e_complete_date[]" class="form-control e_complete_date" data-plugin-selectTwo>
                              <option value="">Select</option>
                              <?php 
  for($k = 1950; $k <= date("Y");$k++){
    ?>
                              <option value="<?php echo $k;?>">
                                <?php echo $k;?>
                              </option>
                              <?php
  }?>
                            </select></th>
                          <th><input type="checkbox" name="e_is_attached1" class="e_is_attached"> </th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>

            </div>

          </div>

          <p style="text-align:center;color:red;" id="p_degree"> </p>
          <div class="row mb-lg">
            <div class="col-sm-9 col-sm-offset-3">

              <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
              <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</div>

<script type="text/javascript">
  function addCustomer() {
   
    var student_doc_types = [];
    var student_docs = [];
    var student_doc_desc = [];
    $('select[name="doc_type[]"]').each(function(){
      var doc_type = $(this).val();
      student_doc_types.push(doc_type);
    });
    $(".file_name").each(function(){
      var doc = $(this).val();
      student_docs.push(doc);
    });

    $(".student_doc_desc").each(function(){
      var desc = $(this).val();
      student_doc_desc.push(desc);
    });

    var qualifaction = [];
    var institution = [];
    var country = [];
    var commence_date = [];
    var complete_date = [];
    var percentage = [];
    var is_attached = [];

    $(".qualifaction").each(function(){
      var val = $(this).val();
      qualifaction.push(val);
    });

    $(".institution").each(function(){
      var val = $(this).val();
      institution.push(val);
    });

    $('select[name="country[]"]').each(function(){
      var val = $(this).val();
      country.push(val);
    });

    $('select[name="commence_date[]"]').each(function(){
      var val = $(this).val();
      commence_date.push(val);
    });

    $('select[name="complete_date[]"]').each(function(){
      var val = $(this).val();
      complete_date.push(val);
    });

    $(".percentage").each(function(){
      var val = $(this).val();
      percentage.push(val);
    });
  
    $(".is_attached").each(function(){
      var val = $(this).prop("checked") ? 1 : 0;
      is_attached.push(val);
    });
    

    var experience = [];
    var e_institution = [];
    var e_position = [];
    var e_country  = [];
    var e_commence_date = [];
    var e_complete_date = [];
    var e_is_attached = [];

    $(".experience").each(function(){
      var val = $(this).val();
      experience.push(val);
    });

    $(".e_institution").each(function(){
      var val = $(this).val();
      e_institution.push(val);
    });

    $(".e_position").each(function(){
      var val = $(this).val();
      e_position.push(val);
    });

    $('select[name="e_country[]"]').each(function(){
      var val = $(this).val();
      e_country.push(val);
    });

    $('select[name="e_commence_date[]"]').each(function(){
      var val = $(this).val();
      e_commence_date.push(val);
    });

    $('select[name="e_complete_date[]"]').each(function(){
      var val = $(this).val();
      e_complete_date.push(val);
    });

    $(".e_is_attached").each(function(){
      var val = $(this).prop("checked") ? 1 : 0;
      e_is_attached.push(val);
    });
  
    var data = {
      "fname": $("#fname").val(),
      "lname": $("#lname").val(),
      "email": $("#email").val(),
      "mobile": $("#mobile").val(),
      "username": $("#username").val(),
      "password": $("#password1").val(),
      "cpassword": $("#cpassword").val(),
      "dob": $("#dob").val(),
      "passport_no": $("#passport_no").val(),
      "phone": $("#phone").val(),
      "referral": $("#user").val(),
      "sex": $("#sex").val(),
      "is_married": $("#is_married").val(),
      "about_us": $("#about_us").val(),
      "send_email": $("#send_email").prop("checked")? 1 : 0,
      "have_ielts": $("input:radio[name=have_ielts]:checked").val(),
      "listening": $("#listening").val(),
      "writing": $("#writing").val(),
      "reading": $("#reading").val(),
      "speaking": $("#speaking").val(),
      "have_toefl": $("input:radio[name=have_toefl]:checked").val(),
      "txt_toefl": $("#txt_toefl").val(),
      "have_pte":  $("input:radio[name=have_pte]:checked").val(),
      "txt_pte": $("#txt_pte").val(),
      "have_sat": $("input:radio[name=have_pte]:checked").val(),
      "txt_sat": $("#txt_sat").val(),
      "have_gre":  $("input:radio[name=have_gre]:checked").val(),
      "txt_gre": $("#txt_gre").val(),
      "have_gmat":  $("input:radio[name=have_gmat]:checked").val(),
      "txt_gmat": $("#txt_gmat").val(),
      "student_doc_types": student_doc_types,
      "student_docs": student_docs,
      "student_doc_desc": student_doc_desc,
      "qualifaction": qualifaction,
      "institution": institution,
      "country": country,
      "commence_date": commence_date,
      "complete_date": complete_date,
      "percentage": percentage,
      "is_attached": is_attached,
      "experience": experience,
      "e_institution": e_institution,
      "e_position": e_position,
      "e_country": e_country,
      "e_commence_date": e_commence_date,
      "e_complete_date": e_complete_date,
      "e_is_attached": e_is_attached,
    }

    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>student/addstudent",
      data: data,
      success: function (msg) {
        var msg = JSON.parse(msg);
        if(msg.result == 'success'){
        $("#customer").append('<option value="' + msg.student_id + '">' + $("#fname").val() + ' '+$("#lname").val()+ '</option>');
        $("#customer").val(msg);
        $(".btn-close").trigger("click");
        }else{
          $("#p_degree").html(msg.err);
        }
        
      }
    });

  }
  $(document).ready(function () {
    $("#chk_referral").click(function () {
      if ($(this).prop("checked")) {
        $('.txt_password').addClass("required");
        $(".div_password").show();
      } else {
        $('.txt_password').removeClass("required");
        $(".div_password").hide();
      }
    });

    $("#link_add_doc").click(function () {
      var num = $(".div_row").length;
      num = num + 1;
      $.ajax({
        url: '<?php echo base_url() ?>student/get_docRow',
        type: "POST",
        data: "num=" + num,
        success: function (data) {
          if (data != "") {
            $("#div_student_document").append(data);
            $(".doc_type").select2();
          }
        }
      });
    });

    $(document).on("click", ".link_remove_doc", function () {
      if (!confirm("Are you sure to delete document?"))
        return false;
      $(this).parent().parent().remove();
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


    $(document).on("change",".student_doc",function(){ 
			var file_data = $(this).prop('files')[0];
			var form_data = new FormData();
			form_data.append('file', file_data);

      var sibling = $(this).siblings('input'); 

			$.ajax({
				url: '<?php echo base_url("");?>student/upload_file', 
				dataType: 'text', 
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (response) {
					img = JSON.parse(response);
          // alert(img.image_name);
          sibling.val(img.image_name);
          sibling.next().html('<a target="_blank" href="<?php echo SITE_URL.'uploads/student_documents/'?>'+img.image_name+'"><i class="fa fa-paperclip" aria-hidden="true"></i></a>');
				},
				error: function (response) {
					$('#post_img_profile').html(response); 
				}
			});
		});

    $("#link_user_client").click(function(){ 
      $("#form_user_model").modal();
      $("#form_user_model").css({"z-index":"9999"});
      $("#referal_form_id").val(1);
    });

    $("#link_about_client").click(function(){ 
      $("#form_about_model").modal();
      $("#form_about_model").css({"z-index":"9999"});
      $("#about_form_id").val(1);
    });

    $("#form_customer").validate();


  });
</script>