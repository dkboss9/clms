  <!--begin::Modal content-->
  <div class="modal-content">
      <!--begin::Modal header-->
      <div class="modal-header" id="kt_modal_add_user_header">
          <!--begin::Modal title-->
          <h2 class="fw-bolder">Add Update</h2>
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
      <div class="row g-9 mb-7">
          <?php  //print_r($this->session->userdata);?>
         <?php echo $result->lead_name;?>
         <?php echo $result->company_name;?><br>
          <?php echo ' Query: '.$result->query.'</br>';?>
          <?php echo ' Requirement: '.$result->requirements.'</br>';?>
          <?php 
      $status = $this->dashboardmodel->get_leadstatus($result->status_id);
      if($result->status_id == 1)
        $class = 'label-warning';
      elseif($result->status_id == 4)
        $class = 'label-danger';
      else
        $class = 'label-success';
      ?>
         Status: <?php echo @$status->status_name;?> <br>
      </div>
      <div class="row g-9 mb-7">
          <?php 
      $docs = $this->lmsmodel->get_documents($result->lead_id);
      if(count($docs) >0){
        foreach ($docs as $doc) {
          echo '<p id="file_'.$doc->doc_id.'"><a href="'.SITE_URL.'uploads/leads/'.$doc->file_name.'" target="_blank">'.$doc->file_name.'</a> &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" rel="'.$doc->doc_id.'" class="link_delete"><span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a> </p>';
        }}else{
          echo "<br>No Document added yet.";
        }
        ?>
      </div>
      <?php 
    $updates = $this->lmsmodel->get_updates($result->lead_id);
  //echo $this->db->last_query();
    foreach ($updates as $update) { ?>
      <hr>
      <div class="row g-9 mb-7" leadid="<?php echo $update->update_id;?>">

          <?php
        if($this->session->userdata("usergroup")){
         echo '<h6 class="txt_update"><span class="span_content">'.$update->content.'</span>
        <a href="javascript:void();" class="link_edit" ><i class="fa fa-edit" style="float:right;"></i></a>
        </h6>';
        }else{
          echo '<h6 class="txt_update"><span class="span_content">'.$update->content.'</span></h6>';
        }?>
          <div class="form_update" style="display:none;">
              <textarea name="update_history"
                  class="update_history form-control"><?php echo $update->content;?></textarea>
              <br>
              <a href="javascript:void();" class="link_lead_update btn btn-primary">Update</a> <a
                  href="javascript:void();" class="link_lead_delete btn btn-danger">Cancel</a>
          </div>
          <?php echo '<p> Added by : '.$update->first_name.' '.$update->last_name.' at '.date("d M Y",$update->added_date).'</p>';?>

      </div>
      <?php } ?>
      <hr>
          <!--begin::Form-->
          <?php 
            if($type == "lead")
                $form_link =  base_url("lms/add_update");
            else
                $form_link =  base_url("appointment/add_update");
          ?>
          <form id="kt_add_lead_update" class="form" action="<?php echo $form_link;?>"
              enctype='multipart/form-data' method="post">
              <!--begin::Scroll-->
              <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true"
                  data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                  data-kt-scroll-dependencies="#kt_modal_add_user_header"
                  data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                  <!--begin::Input group-->
                  <div class="row g-9 mb-7">
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
                          <!--begin::Label-->
                          <label class="required fs-6 fw-bold mb-2">Reminder Date</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <input type="text" name="date" class="form-control form-control-solid mb-3 mb-lg-0"
                              placeholder="" value="<?php echo date("d-m-Y",$result->reminder_date);?>" id="date" />
                          <!--end::Input-->
                          <div class="fv-plugins-message-container invalid-feedback"></div>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-md-6 fv-row fv-plugins-icon-container">
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
                          <label class=" fs-6 fw-bold mb-2">Sale Reps</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <select name="user" class="form-select form-select-solid fw-bolder"
                              <?php if($this->session->userdata("usergroup") != '1' && $this->session->userdata("usergroup") != '7')  echo 'disabled=""';?>>
                              <option value="">Select</option>
                              <?php 
            foreach($users as $user){
              ?>
                              <option <?php if($result->user_id == $user->id) echo 'selected="selected"';?>
                                  value="<?php echo $user->id;?>"><?php echo $user->first_name.' '.$user->last_name;?>
                              </option>
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
                          <label class="required fs-6 fw-bold mb-2">Weightage</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <select name="weightage" class="form-select form-select-solid fw-bolder"
                              <?php if($this->session->userdata("usergroup") != '1' && $this->session->userdata("usergroup") != '7')  echo 'disabled=""';?>>
                              <option value="">Select</option>
                              <?php 
          foreach($weightage as $row){
            ?>
                              <option
                                  <?php if($result->weightage_id == $row->weightage_id) echo 'selected="selected"';?>
                                  value="<?php echo $row->weightage_id;?>"><?php echo $row->name;?></option>
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





                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2 required">Status</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <select name="status" class="form-select form-select-solid fw-bolder"
                          <?php if($this->session->userdata("usergroup") != '1' && $this->session->userdata("usergroup") != '7')  echo 'disabled=""';?>>
                          <!-- <option value="">Select</option> -->
                          <?php 
      //  if($this->session->userdata == 7){
        foreach($leadstatus as $stat){
          ?>
                          <option
                              <?php if($result->status_id == $stat->status_id) echo 'selected="selected"';?>value="<?php echo $stat->status_id;?>">
                              <?php echo $stat->status_name;?></option>
                          <?php
        }
      /*  }else{
          ?>
                          <option value="2">Processing</option>
                          <?php
        }*/
        ?>
                      </select>
                      <!--end::Input-->
                  </div>

                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2">Remark</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <textarea name="remark" class="form-control"><?php echo $result->remark;?></textarea>
                      <!--end::Input-->
                  </div>

                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2">Next Action</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <textarea name="remark" class="form-control"><?php echo $result->next_action;?></textarea>
                      <!--end::Input-->
                  </div>

                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2">Today's Update</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <textarea name="details123" class="form-control" rows="6"></textarea>
                      <!--end::Input-->
                  </div>

              </div>
              <!--end::Scroll-->
              <!--begin::Actions-->
              <div class="text-center pt-15">
                  <input type="hidden" name="txt_submit" value="1">
                  <input type="hidden" value="<?php echo $result->lead_id;?>" name="lead_id">
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
  <script
      src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/apps/user-management/users/list/add_lead.js">
  </script>
  <script
      src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/apps/user-management/users/list/add_lead_update.js">
  </script>