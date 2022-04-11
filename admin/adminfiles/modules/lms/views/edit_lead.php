  <script>
      $(document).ready(function(){
        $("#docs1").select2();
	});
  </script>
  <!--begin::Modal content-->
  <div class="modal-content">
      <!--begin::Modal header-->
      <div class="modal-header" id="kt_modal_add_user_header">
          <!--begin::Modal title-->
          <h2 class="fw-bolder">Edit Lead</h2>
          <!--end::Modal title-->
          <!--begin::Close-->
          <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
              <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
              <span class="svg-icon svg-icon-1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                          transform="rotate(-45 6 17.3137)" fill="black" />
                      <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                          fill="black" />
                  </svg>
              </span>
              <!--end::Svg Icon-->
          </div>
          <!--end::Close-->
      </div>
      <!--end::Modal header-->
      <!--begin::Modal body-->
      <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
          <!--begin::Form-->
          <form id="kt_modal_add_user_form" class="form" action="<?php echo base_url("lms/edit");?>" enctype='multipart/form-data' method="post">
              <!--begin::Scroll-->
              <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true"
                  data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                  data-kt-scroll-dependencies="#kt_modal_add_user_header"
                  data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2">Existing contact</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <select name="contact" id="customer" class="form-select form-select-solid fw-bolder"
                          data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true"
                          data-kt-user-table-filter="role" data-hide-search="true">
                          <option value="">Select</option>
                          <?php 
                      foreach($contacts->result() as $contact){
                    
                        ?>
                             <option value="<?php echo $contact->id;?>" <?php echo $result->student_id == $contact->id ? 'selected' : '';?> firstname="<?php echo trim($contact->first_name);?>" lastname="<?php echo trim($contact->last_name);?>" email="<?php echo $contact->email;?>" phone="<?php echo $contact->phone;?>" address="<?php echo $contact->address?>"><?php echo $contact->first_name;?> <?php echo $contact->last_name;?></option>
                          <?php
                      }
                  ?>
                      </select>
                      <!--end::Input-->
                  </div>

                  <!--begin::Input group-->
                  <div class="row g-9 mb-7">
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class="required fs-6 fw-bold mb-2">First Name</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                              placeholder="" value="<?php echo $result->lead_name;?>" id="firstname" />
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class="required fs-6 fw-bold mb-2">Last Name</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <input type="text" name="lname" class="form-control form-control-solid mb-3 mb-lg-0"
                              placeholder="" value="<?php echo $result->lead_lname;?>" id="lastname" />
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                  </div>

                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="row g-9 mb-7">
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class="required fs-6 fw-bold mb-2">Email</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                              placeholder="" value="<?php echo $result->email;?>" id="lemail" />
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class=" fs-6 fw-bold mb-2">Mobile</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <input type="text" name="phone" class="form-control form-control-solid mb-3 mb-lg-0"
                              placeholder="" value="<?php echo $result->phone_number;?>" id="phone" />
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                  </div>

                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="row g-9 mb-7">
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class=" fs-6 fw-bold mb-2">Purpose</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                              data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role"
                              data-hide-search="true" name="purpose" id="sel_purpose">
                              <option value="">Select</option>
                              <?php 
                foreach($purpose as $row){
                  ?>
                              <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->purpose)  echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
                              <?php
                }
                ?>
                          </select>
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class="fs-6 fw-bold mb-2">How did you know about us?</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                              data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role"
                              data-hide-search="true" name="about_us" id="about_us" data-plugin-selectTwo>
                              <option value="">Select</option>
                              <?php 
                foreach($about_us as $row){
                  ?>
                              <option value="<?php echo $row->threatre_id;?>" <?php if($row->threatre_id == $result->about_us) echo 'selected="selected"';?>><?php echo $row->name;?></option>
                              <?php
                }
                ?>

                          </select>
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                  </div>

                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                      <!--begin::Wrapper-->
                      <div class="d-flex flex-stack">
                          <!--begin::Label-->
                          <div class="me-5">
                              <label class="fs-6 fw-bold">Want to book for counselling ?</label>

                          </div>
                          <!--end::Label-->
                          <!--begin::Switch-->
                          <label class="form-check form-switch form-check-custom form-check-solid">
                              <input class="form-check-input" type="checkbox" value="1" name="conselling"
                                  id="conselling" <?php if($result->is_booked == '1') echo 'checked="checked"';?> />
                              <span class="form-check-label fw-bold text-muted">Yes</span>
                          </label>
                          <!--end::Switch-->
                      </div>
                      <!--end::Wrapper-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="fv-row mb-7 div_consultant" <?php if($result->is_booked != '1') echo 'style="display: none;"';?> >
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2 required">Consultant:</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                          data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role"
                          data-hide-search="true" name="consultant" id="consultant" data-plugin-selectTwo>
                          <option value="">Select</option>
                          <?php 
                  foreach ($employees as $row) {
                   ?>
                          <option value="<?php echo $row->id;?>" <?php if($row->id == $result->consultant) echo 'selected="selected"';?>>
                              <?php echo $row->first_name.' '.$row->last_name;?></option>
                          <?php
                 }
                 ?>
                      </select>
                      <!--end::Input-->

                      <!--end::Input group-->

                      <!--begin::Input group-->
                      <div class="row g-9 mb-7">
                          <!--begin::Col-->
                          <div class="col-md-6 fv-row fv-plugins-icon-container">
                              <!--begin::Label-->
                              <label class="required fs-6 fw-bold mb-2">Booking Date</label>
                              <!--end::Label-->
                              <!--begin::Input-->
                              <input type="text" name="booking_date"
                                  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value="<?php echo date("d-m-Y",strtotime($result->booking_date))?>"
                                  id="booking_date" />
                              <!--end::Input-->
                              <div class="fv-plugins-message-container invalid-feedback"></div>
                          </div>
                          <!--end::Col-->
                          <!--begin::Col-->
                          <div class="col-md-6 fv-row fv-plugins-icon-container">
                              <!--begin::Label-->
                              <label class="required fs-6 fw-bold mb-2">Booking time</label>
                              <!--end::Label-->
                              <!--begin::Input-->
                              <select name="booking_time" id="booking_time"
                                  class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                  data-placeholder="Select option" data-allow-clear="true"
                                  data-kt-user-table-filter="role" data-hide-search="true">
                                  <option></option>
                                  <?php echo $booking_time_options;?>
                              </select>
                              <!--end::Input-->
                              <div class="fv-plugins-message-container invalid-feedback"></div>
                          </div>
                          <!--end::Col-->
                      </div>

                      <!--end::Input group-->

                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fw-bold fs-6 mb-2">Country</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <select name="country" id="country" class="form-select form-select-solid fw-bolder"
                          data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true"
                          data-kt-user-table-filter="role" data-hide-search="true">
                          <option value="">Country</option>
                          <?php
              foreach ($countries as $country) {
               ?>
                          <option <?php if($result->country == $country->country_name) echo 'selected="selected"';?>
                              value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?>
                          </option>
                          <?php
             }
             ?>
                      </select>
                      <!--end::Input-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2">Description</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <textarea name="requirement"
                          class="form-control form-control-solid mb-3 mb-lg-0"><?php echo $result->requirements;?></textarea>

                      <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row g-9 mb-7">
                          <!--begin::Col-->
                          <div class="col-md-6 fv-row fv-plugins-icon-container">
                              <!--begin::Label-->
                              <label class="required fs-6 fw-bold mb-2">Lead Source</label>
                              <!--end::Label-->
                              <!--begin::Input-->
                              <select name="lead_source" id="lead_source" class="form-select form-select-solid fw-bolder"
                          data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true"
                          data-kt-user-table-filter="role" data-hide-search="true">
                          <option value="">Select</option>
                          <?php 
           foreach($source as $row){
            ?>
                          <option value="<?php echo $row->type_id;?>"
                          <?php if($result->lead_source == $row->type_id) echo 'selected="selected"';?>>
                              <?php echo $row->type_name;?></option>
                          <?php
          }
          ?>
                      </select>
                              <!--end::Input-->
                              <div class="fv-plugins-message-container invalid-feedback"></div>
                          </div>
                          <!--end::Col-->
                          <!--begin::Col-->
                          <div class="col-md-6 fv-row fv-plugins-icon-container">
                              <!--begin::Label-->
                              <label class="fs-6 fw-bold mb-2">Weightage</label>
                              <!--end::Label-->
                              <!--begin::Input-->
                              <select name="weightage" id="weightage"
                                  class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                  data-placeholder="Select option" data-allow-clear="true"
                                  data-kt-user-table-filter="role" data-hide-search="true">
                                  <option></option>
                                  <?php 
                                    foreach($weightage as $row){
                                        ?>
                                        <option <?php if($result->weightage_id == $row->weightage_id) echo 'selected="selected"';?> value="<?php echo $row->weightage_id;?>"><?php echo $row->name;?></option>
                                        <?php
                                    }
                                    ?>
                              </select>
                              <!--end::Input-->
                              <div class="fv-plugins-message-container invalid-feedback"></div>
                          </div>
                          <!--end::Col-->
                      </div>

                      <!--end::Input group-->

               
                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2">Attachment</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input type="file" name="profile_image" id="profile_image" class="form-control">
                      <table style="width: 100%;" id="div_document_attachment">
 <?php 

foreach($files as $file){
  ?>
  <tr style="margin-top:10px;" >
    <td> 
      <a href="<?php echo SITE_URL."uploads/document/".$file->doc_name;?>" target="_blank"><?php echo $file->doc_name;?></a>
    </td>
    <td>
      <input type="hidden" name="txt_files[]" class="txt_files" value="<?php echo $file->doc_name;?>"><a href="javascript:void(0);" class="link_remove" > Remove</a>
    </td>
  </tr>
  <?php
}

?>
              </table>
                      <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <!--begin::Input group-->
                  <div class="row g-9 mb-7">
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class=" fs-6 fw-bold mb-2">Referral</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <label class="form-check form-switch form-check-custom form-check-solid">
                              <input class="form-check-input" type="checkbox" <?php if($result->referral == '1') echo 'checked="checked"';?> value="1" name="referral" id="referral" />
                              <span class="form-check-label fw-bold text-muted">Yes</span>
                          </label>
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container div_referral" <?php if($result->referral != '1') echo 'style="display:none;"';?>>
                          <!--begin::Label-->
                          <label class="required fs-6 fw-bold mb-2">Referral</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <select name="user" id="user" class="form-select form-select-solid fw-bolder"
                              data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true"
                              data-kt-user-table-filter="role" data-hide-search="true">
                              <option value="">Select</option>
                              <?php 
          foreach($users as $user){
            ?>
                              <option value="<?php echo $user->id;?>"
                              <?php if($result->user_id == $user->id) echo 'selected="selected"';?>>
                                  <?php echo $user->first_name.' '.$user->last_name;?></option>
                              <?php
          }
          ?>
                          </select>
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="row g-9 mb-7">
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class="required fs-6 fw-bold mb-2 required">Reminder Date</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <input type="text" name="date" class="form-control form-control-solid mb-3 mb-lg-0"
                              placeholder="" value="<?php echo date("d-m-Y",$result->reminder_date);?>" id="date" />
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container ">
                          <!--begin::Label-->
                          <label class="required fs-6 fw-bold mb-2">Reminder Time</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <input type="text" name="time" value="<?php echo $result->reminder_time;?>"
                              class="form-control form-control-solid mb-3 mb-lg-0" id="time">
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="row g-9 mb-7">
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class=" fs-6 fw-bold mb-2 required">Select Email</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <select name="email_template" id="email_template"
                              class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                              data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role"
                              data-hide-search="true">
                              <option value="">Default</option>
                              <?php 
        foreach ($emails as $row){
          ?>
                              <option value="<?php echo $row->id;?>" <?php if($row->id == $result->lead_email_id) echo 'selected';?>><?php echo $row->email_subject;?></option>
                              <?php
        }
        ?>

                          </select>
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container ">
                          <!--begin::Label-->
                          <label class=" fs-6 fw-bold mb-2">Attach Document</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <select name="docs[]" id="docs1" multiple data-plugin-selectTwo
                                class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                data-placeholder="Select option" data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="true">
                              <option value="">Select</option>
                              <?php 
        foreach ($docs as $row){
          ?>
                              <option value="<?php echo $row->content_id;?>" <?php if(in_array($row->content_id, $lead_docs)) echo 'selected="selected"';?>><?php echo $row->name;?></option>
                              <?php
        }
        ?>

                          </select>
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                  <?php 
                $updates = $this->lmsmodel->get_updates($result->lead_id);
                if(count($updates) >0){
                    foreach ($updates as $update) {
                    echo '<p>'.$update->content.'</p>';
                    echo '<p>Added by: '.$update->first_name.' '.$update->last_name.' at '.date("d/m/Y",$update->added_date).'</p>';
                    echo '<hr>';
                    }}else{
                    echo "No Update added yet.";
                    }
                    ?>
                  </div>
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2">Status Update</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <textarea name="status_update" class="form-control form-control-solid mb-3 mb-lg-0"></textarea>
                      <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="row g-9 mb-7">
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class="required fs-6 fw-bold mb-2 required">Status</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <select name="status" id="sel_status" class="form-select form-select-solid fw-bolder"
                              data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true"
                              data-kt-user-table-filter="role" data-hide-search="true">
                              <?php 
        foreach($status as $stat){
          ?>
                              <option value="<?php echo $stat->status_id;?>" <?php if($result->status_id == $stat->status_id) echo 'selected="selected"';?>><?php echo $stat->status_name;?></option>
                              <?php
        }

        ?>
                          </select>
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container ">
                          <!--begin::Label-->
                          <label class=" fs-6 fw-bold mb-2">Send Email ?</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <label class="form-check form-switch form-check-custom form-check-solid">
                              <input class="form-check-input" type="checkbox" value="1" name="send_email"
                                  id="send_email" />
                              <span class="form-check-label fw-bold text-muted">Yes</span>
                          </label>
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                  </div>
                  <!--end::Input group-->
              </div>
              <!--end::Scroll-->
              <!--begin::Actions-->
              <div class="text-center pt-15">
                  <input type="hidden" name="txt_submit" value="1">
                  <input type="hidden" name="lead_id" value="<?php echo $result->lead_id;?>">
                  <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                  <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                      <span class="indicator-label">Submit</span>
                      <span class="indicator-progress">Please wait...
                          <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                  </button>
              </div>
              <!--end::Actions-->
          </form>
          <!--end::Form-->
      </div>
      <!--end::Modal body-->
  </div>
  <!--end::Modal content-->
  <script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/apps/user-management/users/list/add_lead.js">
	</script>
    