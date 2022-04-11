<div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Add Consultant</h2>
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

		  <?php 
    $updates = $this->appointmentmodel->get_updates($result->lead_id);
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
                <form id="kt_modal_add_consultant" class="form" action="<?php echo base_url("appointment/add_consultant/".$result->lead_id);?>" method="post">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
          
                        <!--begin::Input group-->
                        <div class="fv-row mb-7 " >
                            <!--begin::Label-->
                            <label class=" fw-bold fs-6 mb-2 ">counseller:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                data-placeholder="Select option" data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="true" name="consultant"
                                id="consultant" data-plugin-selectTwo>
                                <option value="">Select</option>
								<?php 
					foreach ($employees as $row) {
						?>
						<option value="<?php echo $row->id;?>" <?php if($row->id == $result->consultant) echo 'selected="selected"';?>><?php echo $row->first_name.' '.$row->last_name;?></option>
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
                            <label class=" fw-bold fs-6 mb-2">Today's Update</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="update"
                                class="form-control form-control-solid mb-3 mb-lg-0"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                          <!--begin::Input group-->
                          <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-bold fs-6 mb-2">Status</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                data-placeholder="Select option" data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="true" name="status"
                                id="status" data-plugin-selectTwo>
                                <option value="">Select</option>
								<?php
								foreach($leadstatus as $stat){
						?>
						<option <?php if($result->status_id == $stat->status_id) echo 'selected="selected"';?>value="<?php echo $stat->status_id;?>"><?php echo $stat->status_name;?></option>
						<?php
					}
					?>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                    <input type="hidden" name="lead_id" value="<?php echo $result->lead_id;?>">
                        <input type="hidden" name="txt_submit" value="1">
                        <button type="reset" class="btn btn-light me-3"
                            data-kt-users-modal-action="cancel">Discard</button>
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

        <script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/apps/user-management/users/list/add_appointment.js">
	</script>
	  <script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/apps/user-management/users/list/addconsultant.js">
	</script>